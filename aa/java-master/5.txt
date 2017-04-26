public class BinarySearch {
	public void binarySearch(int array[],int n, int key)
	  {
	    int first, last, middle, search;
	    
	    search = key;
	 
	    first  = 0;
	    last   = n - 1;
	    middle = (first + last)/2;
	 
	    while( first <= last )
	    {
	      if ( array[middle] < search )
	        first = middle + 1;    
	      else if ( array[middle] == search ) 
	      {
	        System.out.println(search + " found at location " + (middle + 1) + ".");
	        break;
	      }
	      else
	         last = middle - 1;
	 
	      middle = (first + last)/2;
	   }
	   if ( first > last )
	      System.out.println(search + " is not present in the list.\n");
	  }
}

package algorithms.sort;

public class BubbleSort {
public int [] bubbleSort(int arr[],int n){ 
    int temp = 0;  int i=0;
     for(; i < n; i++){  
             for(int j=1; j < (n-i); j++){  
                      if(arr[j-1] > arr[j]){  
                             //swap elements  
                             temp = arr[j-1];  
                             arr[j-1] = arr[j];  
                             arr[j] = temp;  
                      		}  
                      
             	}  
             try {
     			Thread.sleep(1000);
     		} catch (InterruptedException e) {
     			// TODO Auto-generated catch block
     			e.printStackTrace();
     		}
             System.out.println("Sorting using Bubble Sort");
     }
          return arr;
	}
}

package algorithms.sort;
public class SelectionSort {
 public int [] selectionSort(int arr[],int n){
	 int i = 0;
	   for (; i < n - 1; i++)  
       {  
           int index = i;  
           for (int j = i + 1; j < n; j++){  
               if (arr[j] < arr[index]){  
                   index = j;//searching for lowest index  
               }  
           }  
           int smallerNumber = arr[index];   
           arr[index] = arr[i];  
           arr[i] = smallerNumber;  
           System.out.println("Sorting using Selection Sort");
           try {
			Thread.sleep(1000);
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
       } 
	   System.out.println("Sorting using Selection Sort");
	 return arr;
 }
}

package lab_programs;
import algorithms.search.*;
import algorithms.sort.*;

class Sort extends Thread{
	String str;
	Sort(int i){
		if(i==1)
			str="Bub";
		else
			str="Sel";
	}
	public void run(){
		int arr[]={5,3,1,6,4};
		int arr1[]={25,23,21,26,24};
		
		int array[];
		int n=5;
		if(str.equals("Bub"))
			{
			BubbleSort bubsort=new BubbleSort();
			array=bubsort.bubbleSort(arr1, n);
			//for(int i=0;i<array.length;i++)
			//System.out.println(array[i]);
			}
			else
			{
				SelectionSort selsort=new SelectionSort();
				array=selsort.selectionSort(arr,n);
				//for(int i=0;i<array.length;i++)
				//System.out.println(array[i]);
			}
		}
	}

class Search extends Thread{
	public void run(){
		int arr[]={15,13,11,16,14};
		int array[];
		int n=5,key=13;
		BubbleSort bubsort=new BubbleSort();
		array=bubsort.bubbleSort(arr, n);
		BinarySearch bs=new BinarySearch();
		bs.binarySearch(array, n, key);
	}
}

public class prg5 {
public static void main(String[] args) {
	/*Sort s1=new Sort(1);
	Sort s2=new Sort(2);
	s1.start();
	s2.start();*/
	Search s3=new Search();
	s3.start();
}
}
