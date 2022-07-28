export default function useFormater(){

    const moneyFormatter = (amount) => {
        // Create our number formatter.
        const formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'PHP',        
        });
        
        return formatter.format(amount); /* $2,500.00 */
    }

    return {
        moneyFormatter,
    }


}

