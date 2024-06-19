import { clsx } from "clsx";
import { twMerge } from "tailwind-merge";

export function cn(...inputs) {
    return twMerge(clsx(inputs));
}

export function generateRandomString(length) {
    var result = "";
    var characters =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

export const numberOptions = {
    preProcess: val => val.replace(/[$,]/g, ''),
    postProcess: val => {
        if (!val) return ''

        if (val === '0' || isNaN(val)) return '0'

        // limit the val, only max 9 digits
        val = val.slice(0, 12)

        return Intl.NumberFormat().format(val);
    }
};

// format to number

export const formatToNumber = (val) => {
    if (!val) return ''

    if (val === '0' || isNaN(val)) return '0'

    return Intl.NumberFormat().format(val).replace(/,/g, '.');
}
