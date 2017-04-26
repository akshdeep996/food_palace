package producer;
import java.util.*;

class Q
{
	int n;
	synchronized int get() 
	{
		System.out.println("withdraw :"+n);
		return n;
	}
	synchronized void put(int n) 
	{
		this.n=n;
		System.out.println("deposit :"+n);
	}
}
class producer implements Runnable
{
	Q q;
	producer (Q q) 
	{
		this.q=q;
		new Thread(this,"producer").start();
	}
	public  void run()
	{
		int i=0;
		while(true)
		{
			q.put(10000);
			try
			{
				Thread.sleep(2000);
			}
			catch(InterruptedException e) 
			{
				e.printStackTrace();
			}
		}
	}
}
class consumer implements Runnable
{
	Q q;
	consumer (Q q)
	{
		this.q=q;
		new Thread(this,"consumer").start();
	}
	public void run()
	{
		while(true){
			q.get();
			try
			{
				Thread.sleep(2000);
			}
			catch(InterruptedException e) 
			{
				e.printStackTrace();
			}
	}
}
}
class pc {
	public static void main(String args[]) 
	{
		Q q=new Q();
		new consumer(q);
		new producer(q);
	}
}



