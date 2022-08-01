export default function useCalculation(){

    const calculateTotalAmount = (pricipalAmount, totalInterest) => {             
       return pricipalAmount + totalInterest;
    }

    const calculateTotalInterest = (principal_amount, interest, terms) => {
        return (principal_amount * (interest / 100)) * terms;    
    }

    const calculateCollectionAmount = (principal_amount, terms) => {
        return principal_amount / terms;
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