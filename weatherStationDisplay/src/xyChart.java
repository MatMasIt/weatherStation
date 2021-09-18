import org.jfree.chart.ChartFactory;
import org.jfree.chart.ChartPanel;
import org.jfree.chart.JFreeChart;
import org.jfree.chart.axis.DateAxis;
import org.jfree.chart.axis.DateTickMarkPosition;
import org.jfree.chart.axis.DateTickUnit;
import org.jfree.chart.axis.DateTickUnitType;
import org.jfree.chart.plot.PlotOrientation;
import org.jfree.chart.plot.XYPlot;
import org.jfree.data.time.Day;
import org.jfree.data.time.TimeSeries;
import org.jfree.data.time.TimeSeriesCollection;
import org.jfree.data.xy.XYSeries;
import org.jfree.data.xy.XYSeriesCollection;

import javax.swing.*;
import java.awt.*;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;

public class xyChart extends JPanel {
    private TimeSeries series1;
    private JFreeChart xylineChart;
    private SimpleDateFormat format;
    private String title,xAxisScore,yAxisScore,datasetName;
    private Color color;
    private ChartPanel chartPanel;
    private TimeSeriesCollection dataset;

    public DataType getD() {
        return d;
    }

    private DataType d;
    public xyChart(String title, String xAxisScore, String yAxisScore, String datasetName, Color color, DataType d) throws ParseException {
        this.d=d;
        this.datasetName=datasetName;
        this.title=title;
        this.xAxisScore=xAxisScore;
        this.yAxisScore=yAxisScore;
        this.color=color;
        this.voidSerie();
    }
    public void voidSerie(){
        try{
            remove(chartPanel);
        }catch(Exception e){

        }
        series1 = new TimeSeries(datasetName);
        format = new SimpleDateFormat("yyyy-MM-dd");
        dataset = new TimeSeriesCollection();
        dataset.addSeries(series1);
        xylineChart = ChartFactory.createXYLineChart(
                title,
                xAxisScore,
                yAxisScore,
                dataset,
                PlotOrientation.VERTICAL,
                true, true, false);

        XYPlot plot = (XYPlot) xylineChart.getPlot();
        DateAxis dateAxis = new DateAxis();
        dateAxis.setDateFormatOverride(new SimpleDateFormat("dd-MM-yyyy"));
        plot.setDomainAxis(dateAxis);

        plot.getRendererForDataset(plot.getDataset(0)).setSeriesPaint(0, color);
        ChartPanel chartpanel = new ChartPanel(xylineChart);
        chartpanel.setPreferredSize(new Dimension(400, 400));
        add(chartpanel);
    }
    public void addRecord(String date,Double data) throws ParseException {
        series1.add(new Day(format.parse(date)),data);
    }
    public void addRecord(Date date, Double data) {
        series1.add(new Day(date),data);
    }

}
