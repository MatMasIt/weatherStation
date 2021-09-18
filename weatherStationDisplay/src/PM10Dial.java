import org.jfree.chart.ChartPanel;
import org.jfree.chart.JFreeChart;
import org.jfree.chart.plot.dial.*;
import org.jfree.chart.ui.GradientPaintTransformType;
import org.jfree.chart.ui.StandardGradientPaintTransformer;
import org.jfree.data.general.DefaultValueDataset;
import org.jfree.data.general.ValueDataset;

import javax.swing.*;
import java.awt.*;

public class PM10Dial extends Dial{
    private JFreeChart jfreechart;
    private DefaultValueDataset dataset;
    public PM10Dial(String topText, String bottomText, double initialValue)
    {
        dataset = new DefaultValueDataset(initialValue);
        JFreeChart jfreechart = createStandardDialChart(topText, bottomText, dataset, 0D, 999D, 100D, 25);
        DialPlot dialplot = (DialPlot)jfreechart.getPlot();
        StandardDialRange standarddialrange = new StandardDialRange(350D, 999D, Color.red);
        standarddialrange.setInnerRadius(0.52000000000000002D);
        standarddialrange.setOuterRadius(0.55000000000000004D);
        dialplot.addLayer(standarddialrange);
        StandardDialRange standarddialrange1 = new StandardDialRange(100D, 350D, Color.orange);
        standarddialrange1.setInnerRadius(0.52000000000000002D);
        standarddialrange1.setOuterRadius(0.55000000000000004D);
        dialplot.addLayer(standarddialrange1);
        StandardDialRange standarddialrange2 = new StandardDialRange(0D, 100D, Color.green);
        standarddialrange2.setInnerRadius(0.52000000000000002D);
        standarddialrange2.setOuterRadius(0.55000000000000004D);
        dialplot.addLayer(standarddialrange2);
        GradientPaint gradientpaint = new GradientPaint(new Point(), new Color(255, 255, 255), new Point(), new Color(170, 170, 220));
        DialBackground dialbackground = new DialBackground(gradientpaint);
        dialbackground.setGradientPaintTransformer(new StandardGradientPaintTransformer(GradientPaintTransformType.VERTICAL));
        dialplot.setBackground(dialbackground);
        dialplot.removePointer(0);
        org.jfree.chart.plot.dial.DialPointer.Pointer pointer = new org.jfree.chart.plot.dial.DialPointer.Pointer();
        pointer.setFillPaint(Color.yellow);
        dialplot.addPointer(pointer);
        ChartPanel chartpanel = new ChartPanel(jfreechart);
        chartpanel.setPreferredSize(new Dimension(400, 400));

        add(chartpanel);
    }
    public void setValue(double v){
        dataset.setValue(v);
    }

}