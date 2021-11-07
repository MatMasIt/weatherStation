package main

import (
	"crypto/md5"
	"encoding/hex"
	"encoding/json"
	"errors"
	"fmt"
	"io"
	"io/ioutil"
	"log"
	"net/http"
	"os"
	"strings"

	"gopkg.in/ini.v1"
)

func hash_file_md5(filePath string) (string, error) {
	//Initialize variable returnMD5String now in case an error has to be returned
	var returnMD5String string

	//Open the passed argument and check for any error
	file, err := os.Open(filePath)
	if err != nil {
		return returnMD5String, err
	}

	//Tell the program to call the following function when the current function returns
	defer file.Close()

	//Open a new hash interface to write to
	hash := md5.New()

	//Copy the file in the hash interface and check for any error
	if _, err := io.Copy(hash, file); err != nil {
		return returnMD5String, err
	}

	//Get the 16 bytes hash
	hashInBytes := hash.Sum(nil)[:16]

	//Convert the bytes to a string
	returnMD5String = hex.EncodeToString(hashInBytes)

	return returnMD5String, nil

}
func DownloadFile(filepath string, url string) error {

	// Get the data
	resp, err := http.Get(url)
	if err != nil {
		return err
	}
	defer resp.Body.Close()

	// Create the file
	out, err := os.Create(filepath)
	if err != nil {
		return err
	}
	defer out.Close()

	// Write the body to file
	_, err = io.Copy(out, resp.Body)
	return err
}

func main() {
	fmt.Println("Fetching configuration")
	cfg, err := ini.Load("d.ini")
	if err != nil {
		fmt.Printf("Cannot read configuration: %v", err)
		os.Exit(1)
	}
	urlProj := cfg.Section("server").Key("url").String()
	urlBase := urlProj + "/directoryData.php?page="
	resp, err := http.Get(urlBase)
	if err != nil {
		log.Fatalln(err)
	}
	//We Read the response body on the line below.
	body, err := ioutil.ReadAll(resp.Body)
	if err != nil {
		log.Fatalln(err)
	}

	// we unmarshal our byteArray which contains our
	// jsonFile's content into 'users' which we defined above
	sb := string(body)
	var result map[string]interface{}

	json.Unmarshal([]byte(sb), &result)

	storedDataPath := cfg.Section("paths").Key("storedDataPath").String()
	os.MkdirAll(storedDataPath, os.ModePerm)

	for i := 1; i < int(result["totalPages"].(float64))+1; i++ {
		fmt.Printf("Considering result page %d of %d\n", i, int(result["totalPages"].(float64)))
		files := result["files"].([]interface{})
		for fi := 0; fi < int(len(files)); fi++ {
			file := files[fi].(map[string]interface{})
			md5 := file["md5"].(string)
			filePathRemote := file["file"].(string)
			s := strings.Split(filePathRemote, "/")
			fileBasename := s[1]
			fmt.Printf("Considering file %d of %d (%s)\n", fi, int(len(files)), fileBasename)
			filenameProjectedPath := storedDataPath + "/" + fileBasename
			if _, err := os.Stat(filenameProjectedPath); errors.Is(err, os.ErrNotExist) {
				DownloadFile(filenameProjectedPath, urlProj+"/"+filePathRemote)
				fmt.Println("File is new, downloading")
			} else if hash, _ := hash_file_md5(filenameProjectedPath); hash != md5 {
				fmt.Println("File hash differs, downloading")
				DownloadFile(filenameProjectedPath, urlProj+"/"+filePathRemote)
			} else {
				fmt.Println("File is ok")
			}
		}
	}
	fmt.Println("My job is done")
}
