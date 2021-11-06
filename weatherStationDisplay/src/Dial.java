import org.jfree.chart.JFreeChart;
import org.jfree.chart.plot.dial.*;
import org.jfree.data.general.ValueDataset;

import javax.swing.*;
import java.awt.*;

public abstract class Dial extends JPanel {
    public static JFreeChart createStandardDialChart(String s, String s1, ValueDataset valuedataset, double lowerBound, double upperBound, double tickMajor, int minorTick)
    {
        DialPlot dialplot = new DialPlot();
        dialplot.setDataset(valuedataset);
        dialplot.setDialFrame(new StandardDialFrame());
        dialplot.setBackground(new DialBackground());
        DialTextAnnotation dialtextannotation = new DialTextAnnotation(s1);
        dialtextannotation.setFont(new Font("Dialog", 1, 14));
        dialtextannotation.setRadius(0.69999999999999996D);
        dialplot.addLayer(dialtextannotation);
        DialValueIndicator dialvalueindicator = new DialValueIndicator(0);
        dialplot.addLayer(dialvalueindicator);
        StandardDialScale standarddialscale = new StandardDialScale(lowerBound, upperBound, -120D, -300D, 10D, 4);
        standarddialscale.setMajorTickIncrement(tickMajor);
        standarddialscale.setMinorTickCount(minorTick);
        standarddialscale.setTickRadius(0.88D);
        standarddialscale.setTickLabelOffset(0.14999999999999999D);
        standarddialscale.setTickLabelFont(new Font("Dialog", 0, 14));
        dialplot.addScale(0, standarddialscale);
        dialplot.addPointer(new org.jfree.chart.plot.dial.DialPointer.Pin());
        DialCap dialcap = new DialCap();
        dialplot.setCap(dialcap);
        return new JFreeChart(s, dialplot);
    }
}
