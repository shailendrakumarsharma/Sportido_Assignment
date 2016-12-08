<?php
class Customer
{
	
	public function getbillingdetails()
	{
		echo "please provide the mandatory details bill amount and one usertype from (1,2,3).<br>you can also provide optional details like Groceries amount and number of years user attached with the bbranch:";
		
		$total_bill = trim(fgets(STDIN));
		$usertype = trim(fgets(STDIN));       //1: Employee, 2: affiliate, 3: general user
		$groceries_amount = trim(fgets(STDIN));
		$userfrom = trim(fgets(STDIN));
		$actual_bill = 0;
		if(($total_bill>0) && (in_array($usertype,array(1,2,3)))) // testing the billing details
		{
			if($total_bill>=100) // Bill based discount calculation
			   $actual_bill = $this->billbaseddiscount($total_bill);
			else 
			   $actual_bill = $total_bill;
			if(($groceries_amount>0) && ($groceries_amount<$total_bill)) // groceries amount validation
			{	
				 $total_bill = $this->getactualtotalbill($total_bill, $groceries_amount);
			}
			elseif($groceries_amount==$total_bill) 
			{
				$actual_bill = "Bill to pay:".$actual_bill;
				return $actual_bill;
			}
			else 
			{
				$actual_bill = "Invalid Groceries bill amount:".$groceries_amount;
				return $actual_bill;
			}
			//checking for usertype
			if($usertype==1)
				$actual_bill = $this->employeediscount($total_bill);
			elseif($usertype==2)
			    $actual_bill = $this->useraffiliatediscount($total_bill);
			elseif($usertype==3)
			{
			    if ($userfrom>=2)
			    	$actual_bill = $this->longtermuserdiscount($total_bill);
			    
			}    
			
			return $actual_bill;
			
		}
		else 
		{
			$actual_bill = "Invalid Entry";
			return $actual_bill;
		}
			
	}
	//Calculating actual bill for discount
	public function getactualtotalbill($total_bill, $groceries_amount)
	{
		$total_bill = $total_bill - $groceries_amount;
		return $total_bill;
	} 
	// Calculating employee discount
	public function employeediscount($total_bill)
	{
		$total_bill = ($total_bill - ($total_bill*0.3));
		return $total_bill;
	}
	// Calculating affiliate user discount
	public function useraffiliatediscount($total_bill)
	{
		$total_bill = ($total_bill - ($total_bill*0.1));
		return $total_bill;
	}
	// Calculating longterm user discount
	public function longtermuserdiscount($total_bill)
	{
		$total_bill = ($total_bill - ($total_bill*0.05));
		return $total_bill;
	}
	// Calculating bill based user discount
	public function billbaseddiscount($total_bill)
	{
	    $limit = 100; 
		$total_discount =((floor($total_bill/$limit))*5);
		$total_bill = $total_bill - $total_discount;
		return $total_bill;
	}
}

$obj = new Customer();
echo 'Actual amount:'.$obj->getbillingdetails();

	