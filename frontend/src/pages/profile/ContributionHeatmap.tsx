import CalendarHeatmap from 'react-calendar-heatmap';
import 'react-calendar-heatmap/dist/styles.css';

export interface Contribution{
    date: string,
    count: number
}

interface ContributionHeatmapProps{
    contributions: Contribution[]
}

export default function ContributionHeatmap(props: ContributionHeatmapProps){
    const today = new Date();

    const maxContribution = props.contributions.length > 0 ? props.contributions
        .map(c => c.count)
        .reduce((a,b) => Math.max(a, b)): 1;

    const normalize = (a) => Math.round(a / maxContribution * 5);


    // Map the contributions to the required format
    return (
        <div>
            <CalendarHeatmap
                startDate={new Date(today.getFullYear() - 1, today.getMonth(), today.getDate())}
                endDate={today}
                values={props.contributions}
                classForValue={(value) => {
                    if (!value) {
                        return 'color-empty';
                    }
                    return `color-scale-${normalize(value.count)}`;
                }}
                showWeekdayLabels={true}
            />
        </div>
    );
}