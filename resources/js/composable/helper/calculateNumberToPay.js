export default function useCalculateNumbersToPay(){

    const calculateNumbersToPay = (amount, amount_to_pay) => {
       return amount / amount_to_pay;
    }

    return  {
        calculateNumbersToPay
    }

}

