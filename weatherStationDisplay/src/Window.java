import org.ini4j.Ini;

import javax.swing.*;
import javax.xml.crypto.Data;
import java.awt.*;
import java.io.File;
import java.io.IOException;
import java.text.ParseException;

public class Window extends JFrame {
    private JMenuBar bar;
    private JMenuItem datetime,connection, flipTime;
    private JStatusTicker jc;
    private JPanel currentGauges,maintenance;
    private JPanel gaugesOne,gaugesTwo,chartOne,chartTwo;
    private xyChart temperaturexy,humidityxy,pressurexy,pm10xy,pm25xy,sxy;
    private final ImageIcon maintIcon;
    private  JLabel maintIconLabel;
    private JLabel dotLabel;

    public JLabel getGraphsHeaderOne() {
        return GraphsHeaderOne;
    }

    public void setGraphsHeaderOne(JLabel graphsHeaderOne) {
        GraphsHeaderOne = graphsHeaderOne;
    }

    public JLabel getGraphsHeaderTwo() {
        return GraphsHeaderTwo;
    }

    public void setGraphsHeaderTwo(JLabel graphsHeaderTwo) {
        GraphsHeaderTwo = graphsHeaderTwo;
    }

    private JLabel GraphsHeaderOne;
    private JLabel GraphsHeaderTwo;
    private final TemperatureDial te;
    private final HumidityDial h;
    private final PressureDial p;

    public TemperatureDial getTe() {
        return te;
    }

    public HumidityDial getH() {
        return h;
    }

    public PressureDial getP() {
        return p;
    }

    public JMenuItem getFlipTime() {
        return flipTime;
    }

    public PM10Dial getPm10() {
        return pm10;
    }

    public PM25Dial getPm25() {
        return pm25;
    }

    public PM25Dial getS() {
        return s;
    }

    private final PM10Dial pm10;
    private final PM25Dial pm25,s;

    private Ini ini;
    private View view;

    /**
     * Main window constructor
     * @param args
     * @throws IOException
     * @throws DirNotFound
     * @throws ParseException
     */
    public Window(String[] args) throws IOException, DirNotFound, ParseException {
        if(args.length!=1){
            System.out.println("Error: an ini config file must be specified");
            System.exit(1);
        }
        else{
             ini = new Ini(new File(args[0]));
        }
        bar=new JMenuBar();
        Font f=new Font("Serif", Font.PLAIN, 20);
        UIManager.put("MenuItem.font", f);
        this.setLayout(new FlowLayout());
        datetime=new JMenuItem("");
        connection= new JMenuItem("");
        bar.add(datetime);
        bar.add(connection);
        this.setJMenuBar(bar);
        String assetsPath=ini.get("paths","assetsPath");
        maintenance= new JPanel();
        maintenance.setLayout(new GridLayout(1,1));
        maintIconLabel= new JLabel();
        dotLabel= new JLabel("v 1.0, 2021, Progetto \"Stazione Meteo\" Mattia Mascarello, Luca Biello, Lorenzo Dellapiana");
        maintIcon = new ImageIcon(assetsPath+"/maintenance.png");
        maintIconLabel.setIcon(maintIcon);
        flipTime= new JMenuItem();
        bar.add(flipTime);
        bar.add(dotLabel);
        maintenance.add(maintIconLabel);
        this.add(maintenance);
        currentGauges=new JPanel();
        gaugesOne= new JPanel();
        gaugesOne.setLayout(new GridBagLayout());
        GridBagConstraints g= new GridBagConstraints();
        g.gridx=0;
        g.gridy=0;
        g.gridwidth=1;
        g.gridheight=1;
        te=  new TemperatureDial("Temperatura","°C",10);
        gaugesOne.add(te,g);
        g= new GridBagConstraints();
        g.gridx=1;
        g.gridy=0;
        g.gridwidth=1;
        g.gridheight=1;
        h=  new HumidityDial("Umidità","%",10);
        gaugesOne.add(h,g);
        g= new GridBagConstraints();
        g.gridx=0;
        g.gridy=1;
        g.gridwidth=1;
        g.gridheight=1;
        p = new PressureDial("Pressione","hPa",1080);
        gaugesOne.add(p,g);
        g= new GridBagConstraints();
        g.gridx=1;
        g.gridy=1;
        g.gridwidth=1;
        g.gridheight=1;
        pm10 = new PM10Dial("PM10","µg/m³",10);
        gaugesOne.add(pm10,g);
        g.gridx=0;
        g.gridy=2;
        g.gridwidth=2;
        g.gridheight=1;
        JLabel pageOne=new JLabel("Pagina 1 di 4",JLabel.CENTER);
        pageOne.setFont(new Font("Serif", Font.PLAIN, 30));

        gaugesOne.add(pageOne,g);
        gaugesTwo= new JPanel();

        gaugesTwo.setLayout(new GridBagLayout());
        g= new GridBagConstraints();
        g.gridx=0;
        g.gridy=0;
        g.gridwidth=1;
        g.gridheight=1;
        pm25=  new PM25Dial("PM2.5","µg/m³",10);
        gaugesTwo.add(pm25,g); g= new GridBagConstraints();
        s=  new PM25Dial("Fumo e vapori infiammabili","µg/m³",10);
        gaugesTwo.add(s,g);
        g.gridx=0;
        g.gridy=2;
        g.gridwidth=2;
        g.gridheight=1;
        JLabel pageTwo=new JLabel("Pagina 2 di 4",JLabel.CENTER);
        pageTwo.setFont(new Font("Serif", Font.PLAIN, 30));

        g= new GridBagConstraints();
        g.gridx=0;
        g.gridy=2;
        g.gridwidth=4;
        gaugesTwo.add(pageTwo,g);
        currentGauges.add(gaugesOne);
        currentGauges.add(gaugesTwo);

        chartOne = new JPanel();
        chartTwo= new JPanel();
        chartOne.setLayout(new GridBagLayout());
        chartTwo.setLayout(new GridBagLayout());
        g= new GridBagConstraints();
        GraphsHeaderOne=new JLabel("Dati giornalieri",JLabel.CENTER);
        GraphsHeaderOne.setFont(new Font("Serif", Font.PLAIN, 30));
        g.gridx=0;
        g.gridy=0;
        g.gridwidth=2;
        g.gridheight=1;
        chartOne.add(GraphsHeaderOne,g);
        temperaturexy= new xyChart("Temperatura","Data","°T","Temperatura", Color.red, DataType.TEMPERATURE);
        g.gridx=0;
        g.gridy=1;
        g.gridwidth=1;
        chartOne.add(temperaturexy,g);
        humidityxy= new xyChart("Umidità","Data","%","Umidità", Color.blue, DataType.HUMIDITY);
        g.gridx=1;
        g.gridy=1;
        g.gridwidth=1;
        chartOne.add(humidityxy,g);
        pressurexy= new xyChart("Pressione","Data","hPa","Pressione", Color.green, DataType.PRESSURE);
        g.gridx=0;
        g.gridy=2;
        g.gridwidth=1;
        chartOne.add(pressurexy,g);
        pm10xy= new xyChart("PM10","Data","µg/m³","PM10", Color.cyan, DataType.PM10);
        g.gridx=1;
        g.gridy=2;
        g.gridwidth=1;
        chartOne.add(pm10xy,g);
        pm25xy= new xyChart("PM2.5","Data","µg/m³","PM2.5", Color.magenta, DataType.PM25);

        g.gridx=0;
        g.gridy=3;
        g.gridwidth=2;
        g.gridheight=1;
        JLabel pageThree=new JLabel("Pagina 3 di 4",JLabel.CENTER);
        pageThree.setFont(new Font("Serif", Font.PLAIN, 30));
        chartOne.add(pageThree,g);
        GraphsHeaderTwo=new JLabel("Dati giornalieri",JLabel.CENTER);
        GraphsHeaderTwo.setFont(new Font("Serif", Font.PLAIN, 30));
        g.gridx=0;
        g.gridy=0;
        g.gridwidth=2;
        g.gridheight=1;
        chartTwo.add(GraphsHeaderTwo,g);
        g.gridx=0;
        g.gridy=1;
        g.gridwidth=1;
        chartTwo.add(pm25xy,g);
        sxy= new xyChart("Fumo","Data","µg/m³","PM2.5", Color.orange, DataType.SMOKE);
        g.gridx=0;
        g.gridy=2;
        g.gridwidth=1;
        chartTwo.add(sxy,g);
        g.gridx=0;
        g.gridy=3;
        g.gridwidth=2;
        g.gridheight=1;
        JLabel pageFour=new JLabel("Pagina 4 di 4",JLabel.CENTER);
        pageFour.setFont(new Font("Serif", Font.PLAIN, 30));
        chartTwo.add(pageFour,g);
        currentGauges.add(chartOne);
        currentGauges.add(chartTwo);
        this.add(currentGauges);
        this.setView(View.MAIN_GAUGES);
        this.setGaugesPage(1);

        jc=new JStatusTicker(this,ini);
        Thread t = new Thread (jc);
        t.start();
    }

    public JMenuBar getBar() {
        return bar;
    }

    public void setBar(JMenuBar bar) {
        this.bar = bar;
    }

    public JMenuItem getDatetime() {
        return datetime;
    }

    public void setDatetime(JMenuItem datetime) {
        this.datetime = datetime;
    }

    public JMenuItem getConnection() {
        return connection;
    }

    public void setConnection(JMenuItem connection) {
        this.connection = connection;
    }

    public JStatusTicker getJc() {
        return jc;
    }

    public void setJc(JStatusTicker jc) {
        this.jc = jc;
    }

    public JPanel getCurrentGauges() {
        return currentGauges;
    }

    public void setCurrentGauges(JPanel currentGauges) {
        this.currentGauges = currentGauges;
    }

    public JPanel getMaintenance() {
        return maintenance;
    }

    public void setMaintenance(JPanel maintenance) {
        this.maintenance = maintenance;
    }

    public ImageIcon getMaintIcon() {
        return maintIcon;
    }

    public JLabel getMaintIconLabel() {
        return maintIconLabel;
    }

    /**
     * set view
     * @param a
     */
    public void setView(View a){
        this.view=a;
        maintenance.setVisible(false);
        currentGauges.setVisible(false);
        if(a.equals(View.MAIN_GAUGES)){
            currentGauges.setVisible(true);
        }
        else if(a.equals(View.MAINTENANCE)){
            maintenance.setVisible(true);
        }
    }

    /**
     * set page
     * @param page
     */
    public void setGaugesPage(int page) {
        if (page > 4) page = 1;
        switch (page) {
            case 1 -> {
                gaugesOne.setVisible(true);
                gaugesTwo.setVisible(false);
                chartOne.setVisible(false);
                chartTwo.setVisible(false);
            }
            case 2 -> {
                gaugesOne.setVisible(false);
                gaugesTwo.setVisible(true);
                chartOne.setVisible(false);
                chartTwo.setVisible(false);
            }
            case 3 -> {
                gaugesOne.setVisible(false);
                gaugesTwo.setVisible(false);
                chartOne.setVisible(true);
                chartTwo.setVisible(false);
            }
            case 4 -> {
                gaugesOne.setVisible(false);
                gaugesTwo.setVisible(false);
                chartOne.setVisible(false);
                chartTwo.setVisible(true);
            }
        }
    }

    public xyChart getTemperaturexy() {
        return temperaturexy;
    }

    public xyChart getHumidityxy() {
        return humidityxy;
    }

    public xyChart getPressurexy() {
        return pressurexy;
    }

    public xyChart getPm10xy() {
        return pm10xy;
    }

    public xyChart getPm25xy() {
        return pm25xy;
    }

    public xyChart getSxy() {
        return sxy;
    }

    public void increaseGaugesPage(){
       this.setGaugesPage(this.getGaugesPage()+1);
    }

    /**
     * Return page
     * @return current showed page
     */
    public int getGaugesPage(){
        if(gaugesOne.isVisible()) return 1;
        else if (gaugesTwo.isVisible()) return 2;
        else if (chartOne.isVisible()) return 3;
        else return 4;
    }

    /**
     * get View
     * @return
     */
    public View getView(){
        return this.view;
    }

    /**
     * The main
     * @param args
     * @throws IOException
     * @throws DirNotFound
     * @throws ParseException
     */
    public static void main(String[] args) throws IOException, DirNotFound, ParseException {
        Window w= new Window(args);
        w.setExtendedState(JFrame.MAXIMIZED_BOTH);
        w.setUndecorated(true);
        w.setVisible(true);
        w.setVisible(true);

    }
}
