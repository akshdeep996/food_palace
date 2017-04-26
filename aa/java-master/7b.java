package lab7;

import java.awt.*;
import java.applet.*;
public class TextScroll extends Applet implements Runnable {
	String str;
	int x;
	public void init()
	{
		str="NMIT";
		x=300;
		new Thread(this).start();
	}
	public void run()
	{
		try{
			for(; ;)
			{
				x-=10;
				if(x<10)
				{
					x=300;
				}
				repaint();
				System.out.println(x);
				Thread.sleep(1000);
			}
		}
		catch(Exception e){} 
	}
			public void paint(Graphics g){
				for(int i=0;i<10;i++)
					g.drawString(str, x, 100);
			}
		}
	



