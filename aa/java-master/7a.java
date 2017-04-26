package lab7;
import java.awt.*;
import java.applet.*;
/*<applet code="ParaDemo.class" width="300" height="80">
<param name=fontName value="Courier"/>
<param name=fontSize value="14"/>
<param name=leading value="2"/>
<param name=accountEnabled value="true"/>
</applet>
*/
public class ParamDemo extends Applet{
String fontName;
int fontSize;
float leading;
boolean accountEnabled;
public void start(){
String param;
fontName=getParameter("fontName");
if(fontName==null)
fontName="not found";
param=getParameter("fontSize");
try{
if(param!=null)
fontSize=Integer.parseInt(param);
else
fontSize=0;
}
catch(NumberFormatException e){
fontSize=-1;
}
param=getParameter("leading");
try{
if(param!=null)
leading=Float.valueOf(param).floatValue();
else
leading=0;
}
catch(NumberFormatException e){
leading=-1;
}
param=getParameter("accountEnabled");
if(param!=null)
accountEnabled=Boolean.valueOf(param).booleanValue();
}
public void paint(Graphics g){
g.drawString("Fontname="+fontName,0,10);
g.drawString("Font size="+fontSize,0,26);
g.drawString("Leading:"+leading,0,42);
g.drawString("AccountEnabled:"+accountEnabled,0,58);
}
public static void main(String[] args)
{
}
}

