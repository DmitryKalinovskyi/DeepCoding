import * as React from 'react';
import Tabs from '@mui/material/Tabs';
import Tab from '@mui/material/Tab';

interface TabPanelProps {
    children?: React.ReactNode;
    index: number;
    value: number;
    className?: string;
}

export function TabPanel(props: TabPanelProps) {
    const { children, className, value, index, ...other } = props;

    return (
        <div
            className={className}
            role="tabpanel"
            hidden={value !== index}
            id={`vertical-tabpanel-${index}`}
            aria-labelledby={`vertical-tab-${index}`}
            {...other}
        >
            {value === index && (
                    <>{children}</>
            )}
        </div>
    );
}

function a11yProps(index: number) {
    return {
        id: `vertical-tab-${index}`,
        'aria-controls': `vertical-tabpanel-${index}`,
    };
}

interface TabControlProps{
    value: number,
    onChange?: (event: React.SyntheticEvent, value: number) => void,
    orientation?: "horizontal" | "vertical",
    labels: string[]
}

export function TabControl(props: TabControlProps) {
    return (
            <Tabs
                orientation={props.orientation}
                value={props.value}
                onChange={props.onChange}
            >
                {props.labels.map((label, index) => {
                    return <Tab key={index} label={label} {...a11yProps(index)} />
                })}
            </Tabs>
    );
}