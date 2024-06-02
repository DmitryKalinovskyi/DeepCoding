import { useState, useEffect } from 'react';

function useSessionStorage(key: string, initialValue: any = "{}") {
    // Get the initial value from localStorage or use the provided initialValue

    const getInitialValue = () => {
        const storedValue = sessionStorage.getItem(key);
        return  JSON.parse(storedValue ?? initialValue);
    };

    const [value, setValue] = useState(getInitialValue);

    // Update localStorage whenever the state changes
    useEffect(() => {
        sessionStorage.setItem(key, JSON.stringify(value));
    }, [key, value]);

    return [value, setValue];
}

export default useSessionStorage;