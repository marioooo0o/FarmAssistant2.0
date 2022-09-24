export function sortAlphabetically(a, b){
    if (typeof a === "number" && typeof b === "number") {
        return a - b;
    }
    else if (typeof a === "string" && typeof b === "string") {
        const lowercaseA = a.toLocaleLowerCase();
        const lowercaseB = b.toLocaleLowerCase();
        return lowercaseA < lowercaseB ? -1 : 1;
    }
    return 0;
};

export function sortDescending(a, b) {
    if (typeof a === "number" && typeof b === "number") {
        return b - a;
    }
    else if (typeof a === "string" && typeof b === "string") {
        const lowercaseA = a.toLocaleLowerCase();
        const lowercaseB = b.toLocaleLowerCase();
        return lowercaseA < lowercaseB ? 1 : -1;
    }
    return 0;
}
export function mySort(data, selector, compare){
    return data.sort((a, b) => compare(selector(a), selector(b)));
};
