package jlab;
import java.util.Scanner;
class customer
{
	String name,accno;
	float balance;

public customer (String name,String accno,float balance)
{
	super();
	this.name=name;
	this.accno=accno;
	this.balance=balance;
}
void transact (float a)
{
	try{
		if(a > 4500)
		{
			throw new transactionnotallowed();
		}
		else	withdraw(a);
	}
catch (transactionnotallowed t)
{
	System.out.println(t);
}
}

void withdraw (float a)
{
	try
		{
			if((balance-a)>1000)
				balance=balance-a;
			else throw new lessbalanceexception();
			}
catch (lessbalanceexception e)
{
	System.out.println(e);
}	
}

void display()
{
	System.out.println("Name:"+name);
	System.out.println("Accno:"+accno);
	System.out.println("Balance:"+balance);
}
}

class lessbalanceexception extends Exception
{
	public String tostring()
	{ 
		return "less balance exception\n";
	}
}

class transactionnotallowed extends Exception
{
	public String tostring()
	{
		return " transaction not allowed\n";
	}
}

public class account {

	public static void main(String[] args)
	{
		System.out.println("enter the amount to be withdrawn");
		Scanner in = new Scanner(System.in);
		float withdraw;
		withdraw = in.nextFloat();
		customer c = new customer("anas","1234567890",5000);
		c.transact(withdraw);
		c.display();

	}
}

