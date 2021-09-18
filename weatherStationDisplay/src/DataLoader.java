import java.io.File;
import java.io.FileNotFoundException;
import java.time.Instant;
import java.util.*;

public class DataLoader {
    private final File dataDir;
    private final String storedDataPath;
    private Window w;
    private HashMap<String,xyChart> charts;

    public double getTemperature() {
        return temperature;
    }

    public double getHumidity() {
        return humidity;
    }

    public double getPressure() {
        return pressure;
    }

    public double getPm10() {
        return pm10;
    }

    public double getPm25() {
        return pm25;
    }

    public double getSmoke() {
        return smoke;
    }

    private double temperature,humidity,pressure,pm10,pm25,smoke;
    public DataLoader(String storedDataPath/*, Window w*/,HashMap<String,xyChart> charts) throws DirNotFound {
        //this.w=w;
        this.charts=charts;
        this.storedDataPath=storedDataPath;
        dataDir=new File(storedDataPath);
        if(!dataDir.isDirectory()) throw new DirNotFound("Directory not found");
        temperature=10;
        humidity=50;
        pressure=950;
        pm10=500;
        pm25=500;
        smoke=500;
    }
    public void update() {
        Boolean temperatureSet=false,humiditySet=false,pressureSet=false,pm10Set=false,pm25Set=false,smokeSet=false;
        //once all are satisfied, the iteration will be stopped
        String[] timeDirs = this.dataDir.list();// list the datetime dirs
        if (timeDirs != null) {//Quit if empty
            Arrays.sort(timeDirs);// Sort the directory names
            String dir = null;
            for (int i = (timeDirs.length-1); i > 0; i--) {// reverse iterate over datetime dirs (most recent)
                if (temperatureSet && humiditySet && pressureSet && pm10Set && pm25Set && smokeSet) break;
                dir = timeDirs[i];
                File chunksF = new File(storedDataPath+"/"+dir);// get current dir object
                String[] chunks = chunksF.list(); // list chunks
                if(chunks != null) {
                    Arrays.sort(chunks); // sort chunks
                    String cfn = null;
                    for (int j = (chunks.length-1); j > 0; j--) { // reverse iterate over chunks (most recent)
                        if (temperatureSet && humiditySet && pressureSet && pm10Set && pm25Set && smokeSet) break;
                        cfn = chunks[j];
                        File chunkF = new File(storedDataPath+"/"+dir+"/"+cfn);
                        Scanner myReader = null;
                        try {
                            myReader = new Scanner(chunkF);
                            while (myReader.hasNextLine()) {
                                if (temperatureSet && humiditySet && pressureSet && pm10Set && pm25Set && smokeSet) break;
                                String data = myReader.nextLine();
                                String[] lineW = data.split(",");
                                try {
                                    if (lineW[1].equals("T") && !temperatureSet) {
                                        temperatureSet = true;
                                        this.temperature = Double.parseDouble(lineW[2]);
                                    } else if (lineW[1].equals("H") && !humiditySet) {
                                        humiditySet = true;
                                        this.humidity = Double.parseDouble(lineW[2]);
                                    } else if (lineW[1].equals("P") && !pressureSet) {
                                        pressureSet = true;
                                        this.pressure = Double.parseDouble(lineW[2]);
                                    } else if (lineW[1].equals("PM10") && !pm10Set) {
                                        pm10Set = true;
                                        this.pm10 = Double.parseDouble(lineW[2]);
                                    } else if (lineW[1].equals("PM25") && !pm25Set) {
                                        pm25Set = true;
                                        this.pm25 = Double.parseDouble(lineW[2]);
                                    } else if (lineW[1].equals("S") && !smokeSet) {
                                        smokeSet = true;
                                        this.smoke = Double.parseDouble(lineW[2]);
                                    }
                                }catch (ArrayIndexOutOfBoundsException e){

                                }
                            }
                            myReader.close();
                        } catch (FileNotFoundException e) {
                            e.printStackTrace();
                        }
                    }
                }
            }
        }

        if (!temperatureSet) temperature = 10;
        if (!humiditySet) humidity = 50;
        if (!pressureSet) pressure = 950;
        if (!pm10Set) pm10=500;
        if(!pm25Set) pm25=500;
        if(!smokeSet) smoke=500;
    }
    public void update(TimeFrame t){
        Boolean escape = false;
        String[] timeDirs = this.dataDir.list();// list the datetime dirs
        long unix = 0;
        if (timeDirs != null) {//Quit if empty
            Arrays.sort(timeDirs);// Sort the directory names
            String dir = null;
            for (int i = (timeDirs.length-1); i > 0; i--) {// reverse iterate over datetime dirs (most recent)
                if (escape) break;
                dir = timeDirs[i];
                File chunksF = new File(storedDataPath+"/"+dir);// get current dir object
                if(chunksF.getName().equals("last")) continue;
                unix = Long.parseLong(chunksF.getName());
                /* Remember that we go from most recent to less recent */
                if(t.equals(TimeFrame.TODAY)){
                    Calendar date = new GregorianCalendar();
                    // reset hour, minutes, seconds and millis
                    date.set(Calendar.HOUR_OF_DAY, 0);
                    date.set(Calendar.MINUTE, 0);
                    date.set(Calendar.SECOND, 0);
                    date.set(Calendar.MILLISECOND, 0);
                    long todayStart = date.getTimeInMillis()/1000;
                    date.add(Calendar.DAY_OF_MONTH, 1);
                    long todayEnd = date.getTimeInMillis()/1000;
                    if(unix>todayEnd || unix<todayStart){
                        escape=true;
                        break;
                    }
                }
                else if(t.equals(TimeFrame.YESTERDAY)){
                    Calendar date = new GregorianCalendar();
                    // reset hour, minutes, seconds and millis
                    date.set(Calendar.HOUR_OF_DAY, 0);
                    date.set(Calendar.MINUTE, 0);
                    date.set(Calendar.SECOND, 0);
                    date.set(Calendar.MILLISECOND, 0);
                    long yesterdayEnd = date.getTimeInMillis()/1000;
                    date.add(Calendar.DAY_OF_MONTH, -1);
                    long yesterdayStart = date.getTimeInMillis()/1000;
                    if(unix>yesterdayEnd) continue;
                    if(unix<yesterdayStart){
                        escape=true;
                        break;
                    }
                }
                else if(t.equals(TimeFrame.THIS_WEEK)){
                    Calendar currentCalendar = Calendar.getInstance();
                    currentCalendar.setFirstDayOfWeek(Calendar.MONDAY);
                    long currentWeekStart = currentCalendar.getTimeInMillis()/1000;

                    currentCalendar.add(Calendar.DATE, 6); //add 6 days after Monday
                    long currentWeekEnd = currentCalendar.getTimeInMillis()/1000;
                    if(unix>currentWeekEnd) continue;
                    if(unix<currentWeekStart){
                        escape=true;
                        break;
                    }
                }
                else if(t.equals(TimeFrame.LAST_WEEK)){
                    Calendar currentCalendar = Calendar.getInstance();
                    currentCalendar.add(Calendar.DAY_OF_MONTH, -7);
                    currentCalendar.setFirstDayOfWeek(Calendar.MONDAY);
                    long lastWeekStart = currentCalendar.getTimeInMillis()/1000;

                    currentCalendar.add(Calendar.DATE, 6); //add 6 days after Monday
                    long lastWeekEnd = currentCalendar.getTimeInMillis()/1000;
                    if(unix>lastWeekEnd) continue;
                    if(unix<lastWeekStart){
                        escape=true;
                        break;
                    }
                }
                else if(t.equals(TimeFrame.THIS_MONTH)){
                    Calendar date = new GregorianCalendar();
                    // reset hour, minutes, seconds and millis
                    date.set(Calendar.HOUR_OF_DAY, 0);
                    date.set(Calendar.MINUTE, 0);
                    date.set(Calendar.SECOND, 0);
                    date.set(Calendar.MILLISECOND, 0);
                    date.set(Calendar.DAY_OF_MONTH,1);
                    long thisMonthStart = date.getTimeInMillis()/1000;
                    date.add(Calendar.DAY_OF_MONTH, date.getActualMaximum(Calendar.DAY_OF_MONTH)-1);
                    long thisMonthEnd = date.getTimeInMillis()/1000;
                    if(unix>thisMonthEnd) continue;
                    if(unix<thisMonthStart){
                        escape=true;
                        break;
                    }
                }
                else if(t.equals(TimeFrame.LAST_MONTH)){
                    Calendar date = new GregorianCalendar();
                    // reset hour, minutes, seconds and millis
                    date.set(Calendar.HOUR_OF_DAY, 0);
                    date.set(Calendar.MINUTE, 0);
                    date.set(Calendar.SECOND, 0);
                    date.set(Calendar.MILLISECOND, 0);
                    date.set(Calendar.DAY_OF_MONTH,1);
                    date.add(Calendar.MONTH,-1);
                    long lastMonthStart = date.getTimeInMillis()/1000;
                    date.add(Calendar.DAY_OF_MONTH, date.getActualMaximum(Calendar.DAY_OF_MONTH)-1);
                    long lastMonthEnd = date.getTimeInMillis()/1000;
                    if(unix>lastMonthEnd) continue;
                    if(unix<lastMonthStart){
                        escape=true;
                        break;
                    }
                }
                String[] chunks = chunksF.list(); // list chunks
                if(chunks != null) {
                    Arrays.sort(chunks); // sort chunks
                    String cfn = null;
                    for (int j = (chunks.length-1); j > 0; j--) { // reverse iterate over chunks (most recent)
                        if (escape) break;
                        cfn = chunks[j];
                        File chunkF = new File(storedDataPath+"/"+dir+"/"+cfn);
                        Scanner myReader = null;
                        try {
                            myReader = new Scanner(chunkF);
                            while (myReader.hasNextLine()) {
                                if (escape) break;
                                String data = myReader.nextLine();
                                String[] lineW = data.split(",");
                                try {
                                    if(charts.containsKey(lineW[1])) {
                                        xyChart c = charts.get(lineW[1]);
                                        c.addRecord(Date.from(Instant.ofEpochSecond(Long.parseLong(lineW[0]))), Double.parseDouble(lineW[2]));
                                    }
                                }catch (Exception e){

                                }
                            }
                            myReader.close();
                        } catch (FileNotFoundException e) {
                            e.printStackTrace();
                        }
                    }
                }
            }
        }
    }

}
