package tour;

interface TourPlan
{
abstract void chennaitoindore(String mode,double fare);
abstract void indoretodelhi(String mode,double fare);
abstract void total();
}

class TravelAgent implements TourPlan
{
	double p1,p2;
	public void chennaitoindore(String mode,double fare)
	{
		System.out.println("tarvelling from chennai to indore by:"+mode+ "and fare is:"+fare);
		this.p1=fare;	
	}
	public void indoretodelhi(String mode,double fare){
		System.out.println("tarvelling from Indore to Delhiby:"+mode+ "and fare is:"+fare);
		this.p2=fare;	
}

	public void total() {
		
		System.out.println("the total fare is "+((this.p1+this.p2)));
	}
	}

public class Travelplan {

	public static void main(String[] args) {
		TravelAgent t1 = new TravelAgent();
		t1.chennaitoindore("plane",6000);
		t1.indoretodelhi("train",2000);
		t1.total();
	}
}

