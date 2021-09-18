import org.ini4j.Ini;

import javax.swing.*;
import java.io.*;
import java.sql.Time;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Scanner;

class JStatusTicker implements Runnable {
    private JMenuItem datetime,connection;
    private long ticks;
    private final String conntypePath;
    private final ImageIcon wifi,wired,noconn;
    private String assetsPath;
    private Window w;
    private View lastInterruptedView;
    private DataLoader l;
    private final int viewVinterval;
    private final int pullDataInterval;
    private final int changeTimeFrame;
    private HashMap<String,xyChart> charts;
    private ArrayList<TimeFrame> timeFrames;
    private ArrayList<String> timeFramesName;
    private int showTf=0;

    /**
     * JStatusTicker
     * @param w
     * @param ini
     * @throws DirNotFound
     */
    public JStatusTicker(Window w,Ini ini) throws DirNotFound {
        this.w=w;
        assetsPath=ini.get("paths","assetsPath");
        viewVinterval= Integer.parseInt(ini.get("UI","viewInterval"));
        pullDataInterval= Integer.parseInt(ini.get("UI","pullDataInterval"));
        changeTimeFrame= Integer.parseInt(ini.get("UI","changeTimeFrame"));
        ticks=0;
        this.conntypePath = assetsPath+"/conntype.sh";
        wifi=new ImageIcon(assetsPath+"/wifi.png");
        wired=new ImageIcon(assetsPath+"/wired.png");
        noconn=new ImageIcon(assetsPath+"/noconn.png");
        datetime=w.getDatetime();
        connection=w.getConnection();
        charts= new HashMap<String,xyChart>();
        charts.put("T",w.getTemperaturexy());
        charts.put("H",w.getHumidityxy());
        charts.put("P",w.getPressurexy());
        charts.put("PM10",w.getPm10xy());
        charts.put("PM25",w.getPm25xy());
        charts.put("S",w.getSxy());

        l= new DataLoader(ini.get("paths","storedDataPath"),charts);
        timeFrames= new ArrayList<TimeFrame>();
        timeFrames.add(TimeFrame.TODAY);
        timeFrames.add(TimeFrame.YESTERDAY);
        timeFrames.add(TimeFrame.THIS_WEEK);
        timeFrames.add(TimeFrame.LAST_WEEK);
        timeFrames.add(TimeFrame.THIS_MONTH);
        timeFrames.add(TimeFrame.LAST_MONTH);
        timeFramesName = new ArrayList<String>();
        timeFramesName.add("Dati di oggi");
        timeFramesName.add("Dati di ieri");
        timeFramesName.add("Dati di questa settimana");
        timeFramesName.add("Dati della scorsa settimana");
        timeFramesName.add("Dati di questo mese");
        timeFramesName.add("Dati dello scorso mese");
    }

    public void run() {
        LocalDateTime dateObj = null;
        long flipC=1;
        DateTimeFormatter format = DateTimeFormatter.ofPattern("dd/MM/yyyy HH:mm:ss");
        while (true) {
            dateObj=LocalDateTime.now();
            datetime.setText(dateObj.format(format));
            try {
                Thread.sleep(500);
            } catch (InterruptedException e) {
                e.printStackTrace();
            }
            if(this.ticks%2==0) {
                Process p;
                try {
                    String[] cmd = {"sh", this.conntypePath};
                    p = Runtime.getRuntime().exec(cmd);
                    p.waitFor();
                    BufferedReader reader = new BufferedReader(new InputStreamReader(
                            p.getInputStream()));
                    String line;
                    while ((line = reader.readLine()) != null) {
                        if(line.equals("NO")){
                            connection.setText("Nessuna Connessione");
                            connection.setIcon(noconn);
                            break;
                        }
                        else if(line.contains("wireless")){
                            connection.setText("Wifi | "+line.split(",")[1]);
                            connection.setIcon(wifi);
                        }
                        else{
                            connection.setText("Ethernet");
                            connection.setIcon(wired);
                        }
                    }
                } catch (IOException | InterruptedException e) {
                    e.printStackTrace();
                }
            }
            if(this.ticks%2==0) {
                Scanner scanner = null;
                try {
                    scanner = new Scanner( new File(assetsPath+"/maintenance") );
                    String text = scanner.useDelimiter("\\A").next();
                    scanner.close();
                    if(text.contains("YES")){
                        if(!w.getView().equals(View.MAINTENANCE)) lastInterruptedView=w.getView();
                        w.setView(View.MAINTENANCE);
                    }
                    else if(w.getView().equals(View.MAINTENANCE)){
                        w.setView(lastInterruptedView);
                    }
                } catch (FileNotFoundException e) {
                    e.printStackTrace();
                }

            }
            if(this.ticks%viewVinterval==0 && this.ticks!=0){
                w.increaseGaugesPage();
            }
            if(this.ticks%pullDataInterval==0){
                l.update();
                w.getTe().setValue((l.getTemperature()));
                w.getH().setValue((l.getHumidity()));
                w.getP().setValue((l.getPressure()));
                w.getPm10().setValue((l.getPm10()));
                w.getPm25().setValue((l.getPm25()));
                w.getS().setValue((l.getSmoke()));
            }
            if(this.ticks%changeTimeFrame==0){
                if(showTf>(timeFrames.size()-1)) showTf=0;
                l.update(timeFrames.get(showTf));
                w.getGraphsHeaderOne().setText(timeFramesName.get(showTf));
                w.getGraphsHeaderTwo().setText(timeFramesName.get(showTf));
                showTf++;
            }
            flipC=this.ticks;
            while(flipC%viewVinterval!=0){
                flipC++;
            }
            w.getFlipTime().setText(String.valueOf(flipC-this.ticks)+ "s");
            this.ticks++;
        }
    }
}