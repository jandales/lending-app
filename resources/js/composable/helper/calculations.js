export default function useCalculation(){

    const paymentTypes =  (payment_type) => {

        switch(payment_type) 
        {
            case  'daily':
                 return 1;

            case  'weekly':
                 return 7;

            case '15days' : 
                return 15;

            default:
                return 30;
        }
    }
        


    const calculateTotalAmount = (pricipalAmount, totalInterest) => {             
       return pricipalAmount + totalInterest;
    }

    const calculateTotalInterest = (principal_amount, interest, terms) => {
        return (principal_amount * (interest / 100)) * terms;    
    }

    const calculateCollectionAmount = (principal_amount, terms, payment_type) => {
        
        payment_type = paymentTypes(payment_type);
        const daystoPay = Math.ceil((terms * 30) / payment_type);       
        const amount = principal_amount / daystoPay
        return  Math.round(amount);
  
    }

    const calculateInterest = (principal_amount, interest) => {
        return principal_amount * (interest / 100);  
    }

   

    return {
        calculateTotalAmount,
        calculateTotalInterest,
        calculateCollectionAmount,
        calculateInterest,
    } 

}