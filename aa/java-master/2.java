package java;


abstract class vehicle {

	String fuel;
	public vehicle(String fuel)
	{
		super();
		this.fuel=fuel;	
	}
	void displayfuelstatus()
	{
		System.out.println("fuel status is "+fuel);
	}
	abstract void topspeed();
}

class car extends vehicle
{
	int topspeed;
	
	public car(String fuel,int topspeed)
	{
		super(fuel);
		this.topspeed=topspeed;
	}

	void topspeed()
	{
		System.out.println("top speed is of car is:"+""+topspeed);
	}
}
class bike extends vehicle
	{
		int topspeed;
		bike(String fuel,int topspeed)
		{
			super(fuel);
			this.topspeed=topspeed;
		}

		void topspeed()
		{
			System.out.println("top speed is of bike is:"+""+topspeed);
		}
	}
	class abc
	{
	public static void main(String[] args) 
	{
		car cr = new car("full",150);
		cr.displayfuelstatus();
		cr.topspeed();
		bike bk = new bike("full",100);
		bk.displayfuelstatus();
		bk.topspeed();

	}
}
