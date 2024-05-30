import React from "react";
import {cn} from "../lib/utils.ts";

interface SelectProps
    extends React.SelectHTMLAttributes<HTMLSelectElement> {}

const Select = React.forwardRef<HTMLSelectElement, SelectProps>(
    ({ className, children, ...props }, ref) => {
        return (
            <select
                className={cn(
                    ' rounded-md border px-2 disabled:cursor-not-allowed disabled:opacity-50',
                    className
                )}
                ref={ref}
                {...props}
            >
                {children}
            </select>
        )
    }
)

export default Select;