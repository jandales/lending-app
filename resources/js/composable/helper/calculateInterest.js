export default function useCalculateInterest(){

    const calculateInterest = (amount, interest) => {
        console.log(interest)
       const total = amount + (amount * (interest / 100))
       console.log(total);
       return total;
    }

    return {
        calculateInterest
    } 

}