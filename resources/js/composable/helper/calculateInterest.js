export default function useCalculateInterest(){

    const calculateInterest = (amount, interest) => {      
       const total = amount + (amount * (interest / 100))   
       return total;
    }

    return {
        calculateInterest
    } 

}