import CalendarHeatmap from 'react-calendar-heatmap';
import 'react-calendar-heatmap/dist/styles.css';

interface Contribution{
    date: string,
    count: number
}

export default function ContributionHeatmap(){
    const today = new Date();
    // Map the contributions to the required format
    return (
        <div>
            <CalendarHeatmap
                startDate={new Date(today.getFullYear() - 1, today.getMonth(), today.getDate())}
                endDate={today}
                values={contributions}
                classForValue={(value) => {
                    if (!value) {
                        return 'color-empty';
                    }
                    return `color-scale-${value.count}`;
                }}
                showWeekdayLabels={true}
            />
        </div>
    );
};

const contributions: Contribution[]  = [
    { date: '2023-05-01', count: 1 },
    { date: '2023-05-02', count: 2 },
    { date: '2023-05-03', count: 1 },
    { date: '2023-05-04', count: 0 },
    { date: '2023-05-05', count: 3 },
    { date: '2023-05-06', count: 2 },
    { date: '2023-05-07', count: 1 },
    { date: '2023-05-08', count: 0 },
    { date: '2023-05-09', count: 4 },
    { date: '2023-05-10', count: 2 },
    { date: '2023-05-11', count: 1 },
    { date: '2023-05-12', count: 0 },
    { date: '2023-05-13', count: 3 },
    { date: '2023-05-14', count: 2 },
    { date: '2023-05-15', count: 1 },
    { date: '2023-05-16', count: 4 },
    { date: '2023-05-17', count: 2 },
    { date: '2023-05-18', count: 1 },
    { date: '2023-05-19', count: 0 },
    { date: '2023-05-20', count: 3 },
    { date: '2023-05-21', count: 2 },
    { date: '2023-05-22', count: 1 },
    { date: '2023-05-23', count: 0 },
    { date: '2023-05-24', count: 4 },
    { date: '2023-05-25', count: 2 },
    { date: '2023-05-26', count: 1 },
    { date: '2023-05-27', count: 0 },
    { date: '2023-05-28', count: 3 },
    { date: '2023-05-29', count: 2 },
    { date: '2023-05-30', count: 1 },
    { date: '2023-05-31', count: 4 },
    // Add more data points here
    { date: '2023-06-01', count: 3 },
    { date: '2023-06-02', count: 2 },
    { date: '2023-06-03', count: 1 },
    { date: '2023-06-04', count: 0 },
    { date: '2023-06-05', count: 3 },
    { date: '2023-06-06', count: 2 },
    { date: '2023-06-07', count: 1 },
    { date: '2023-06-08', count: 4 },
    { date: '2023-06-09', count: 2 },
    { date: '2023-06-10', count: 1 },
    { date: '2023-06-11', count: 0 },
    { date: '2023-06-12', count: 3 },
    { date: '2023-06-13', count: 2 },
    { date: '2023-06-14', count: 1 },
    { date: '2023-06-15', count: 4 },
    { date: '2023-06-16', count: 2 },
    { date: '2023-06-17', count: 1 },
    { date: '2023-06-18', count: 0 },
    { date: '2023-06-19', count: 3 },
    { date: '2023-06-20', count: 2 },
    { date: '2023-06-21', count: 1 },
    { date: '2023-06-22', count: 0 },
    { date: '2023-06-23', count: 4 },
    { date: '2023-06-24', count: 2 },
    { date: '2023-06-25', count: 1 },
    { date: '2023-06-26', count: 0 },
    { date: '2023-06-27', count: 3 },
    { date: '2023-06-28', count: 2 },
    { date: '2023-06-29', count: 1 },
    { date: '2023-06-30', count: 4 },
    // Continue for more months
    { date: '2023-07-01', count: 3 },
    { date: '2023-07-02', count: 2 },
    { date: '2023-07-03', count: 1 },
    { date: '2023-07-04', count: 0 },
    { date: '2023-07-05', count: 3 },
    { date: '2023-07-06', count: 2 },
    { date: '2023-07-07', count: 1 },
    { date: '2023-07-08', count: 4 },
    { date: '2023-07-09', count: 2 },
    { date: '2023-07-10', count: 1 },
    { date: '2023-07-11', count: 0 },
    { date: '2023-07-12', count: 3 },
    { date: '2023-07-13', count: 2 },
    { date: '2023-07-14', count: 1 },
    { date: '2023-07-15', count: 4 },
    { date: '2023-07-16', count: 2 },
    { date: '2023-07-17', count: 1 },
    { date: '2023-07-18', count: 0 },
    { date: '2023-07-19', count: 3 },
    { date: '2023-07-20', count: 2 },
    { date: '2023-07-21', count: 1 },
    { date: '2023-07-22', count: 0 },
    { date: '2023-07-23', count: 4 },
    { date: '2023-07-24', count: 2 },
    { date: '2023-07-25', count: 1 },
    { date: '2023-07-26', count: 0 },
    { date: '2023-07-27', count: 3 },
    { date: '2023-07-28', count: 2 },
    { date: '2023-07-29', count: 1 },
    { date: '2023-07-30', count: 4 },
    { date: '2023-07-31', count: 3 },
    { date: '2023-08-01', count: 2 },
    { date: '2023-08-02', count: 1 },
    { date: '2023-08-03', count: 0 },
    { date: '2023-08-04', count: 3 },
    { date: '2023-08-05', count: 2 },
    { date: '2023-08-06', count: 1 },
    { date: '2023-08-07', count: 4 },
    { date: '2023-08-08', count: 2 },
    { date: '2023-08-09', count: 1 },
    { date: '2023-08-10', count: 0 },
    { date: '2023-08-11', count: 3 },
    { date: '2023-08-12', count: 2 },
    { date: '2023-08-13', count: 1 },
    { date: '2023-08-14', count: 4 },
    { date: '2023-08-15', count: 2 },
    { date: '2023-08-16', count: 1 },
    { date: '2023-08-17', count: 0 },
    { date: '2023-08-18', count: 3 },
    { date: '2023-08-19', count: 2 },
    { date: '2023-08-20', count: 1 },
    { date: '2023-08-21', count: 0 },
    { date: '2023-08-22', count: 4 },
    { date: '2023-08-23', count: 2 },
    { date: '2023-08-24', count: 1 },
    { date: '2023-08-25', count: 0 },
    { date: '2023-08-26', count: 3 },
    { date: '2023-08-27', count: 2 },
    { date: '2023-08-28', count: 1 },
    { date: '2023-08-29', count: 4 },
    { date: '2023-08-30', count: 3 },
    { date: '2023-08-31', count: 2 },
    { date: '2023-09-01', count: 1 },
    { date: '2023-09-02', count: 0 },
    { date: '2023-09-03', count: 3 },
    { date: '2023-09-04', count: 2 },
    { date: '2023-09-05', count: 1 },
    { date: '2023-09-06', count: 4 },
    { date: '2023-09-07', count: 2 },
    { date: '2023-09-08', count: 1 },
    { date: '2023-09-09', count: 0 },
    { date: '2023-09-10', count: 3 },
    { date: '2023-09-11', count: 2 },
    { date: '2023-09-12', count: 1 },
    { date: '2023-09-13', count: 4 },
    { date: '2023-09-14', count: 2 },
    { date: '2023-09-15', count: 1 },
    { date: '2023-09-16', count: 0 },
    { date: '2023-09-17', count: 3 },
    { date: '2023-09-18', count: 2 },
    { date: '2023-09-19', count: 1 },
    { date: '2023-09-20', count: 0 },
    { date: '2023-09-21', count: 4 },
    { date: '2023-09-22', count: 2 },
    { date: '2023-09-23', count: 1 },
    { date: '2023-09-24', count: 0 },
    { date: '2023-09-25', count: 3 },
    { date: '2023-09-26', count: 2 },
    { date: '2023-09-27', count: 1 },
    { date: '2023-09-28', count: 4 },
    { date: '2023-09-29', count: 3 },
    { date: '2023-09-30', count: 2 },
    { date: '2023-10-01', count: 1 },
    { date: '2023-10-02', count: 0 },
    { date: '2023-10-03', count: 3 },
    { date: '2023-10-04', count: 2 },
    { date: '2023-10-05', count: 1 },
    { date: '2023-10-06', count: 4 },
    { date: '2023-10-07', count: 2 },
    { date: '2023-10-08', count: 1 },
    { date: '2023-10-09', count: 0 },
    { date: '2023-10-10', count: 3 },
    { date: '2023-10-11', count: 2 },
    { date: '2023-10-12', count: 1 },
    { date: '2023-10-13', count: 4 },
    { date: '2023-10-14', count: 2 },
    { date: '2023-10-15', count: 1 },
    { date: '2023-10-16', count: 0 },
    { date: '2023-10-17', count: 3 },
    { date: '2023-10-18', count: 2 },
    { date: '2023-10-19', count: 1 },
    { date: '2023-10-20', count: 0 },
    { date: '2023-10-21', count: 4 },
    { date: '2023-10-22', count: 2 },
    { date: '2023-10-23', count: 1 },
    { date: '2023-10-24', count: 0 },
    { date: '2023-10-25', count: 3 },
    { date: '2023-10-26', count: 2 },
    { date: '2023-10-27', count: 1 },
    { date: '2023-10-28', count: 4 },
    { date: '2023-10-29', count: 3 },
    { date: '2023-10-30', count: 2 },
    { date: '2023-10-31', count: 1 },
    { date: '2023-11-01', count: 0 },
    { date: '2023-11-02', count: 3 },
    { date: '2023-11-03', count: 2 },
    { date: '2023-11-04', count: 1 },
    { date: '2023-11-05', count: 4 },
    { date: '2023-11-06', count: 2 },
    { date: '2023-11-07', count: 1 },
    { date: '2023-11-08', count: 0 },
    { date: '2023-11-09', count: 3 },
    { date: '2023-11-10', count: 2 },
    { date: '2023-11-11', count: 1 },
    { date: '2023-11-12', count: 4 },
    { date: '2023-11-13', count: 2 },
    { date: '2023-11-14', count: 1 },
    { date: '2023-11-15', count: 0 },
    { date: '2023-11-16', count: 3 },
    { date: '2023-11-17', count: 2 },
    { date: '2023-11-18', count: 1 },
    { date: '2023-11-19', count: 0 },
    { date: '2023-11-20', count: 4 },
    { date: '2023-11-21', count: 2 },
    { date: '2023-11-22', count: 1 },
    { date: '2023-11-23', count: 0 },
    { date: '2023-11-24', count: 3 },
    { date: '2023-11-25', count: 2 },
    { date: '2023-11-26', count: 1 },
    { date: '2023-11-27', count: 4 },
    { date: '2023-11-28', count: 3 },
    { date: '2023-11-29', count: 2 },
    { date: '2023-11-30', count: 1 },
    { date: '2023-12-01', count: 0 },
    { date: '2023-12-02', count: 3 },
    { date: '2023-12-03', count: 2 },
    { date: '2023-12-04', count: 1 },
    { date: '2023-12-05', count: 4 },
    { date: '2023-12-06', count: 2 },
    { date: '2023-12-07', count: 1 },
    { date: '2023-12-08', count: 0 },
    { date: '2023-12-09', count: 3 },
    { date: '2023-12-10', count: 2 },
    { date: '2023-12-11', count: 1 },
    { date: '2023-12-12', count: 4 },
    { date: '2023-12-13', count: 2 },
    { date: '2023-12-14', count: 1 },
    { date: '2023-12-15', count: 0 },
    { date: '2023-12-16', count: 3 },
    { date: '2023-12-17', count: 2 },
    { date: '2023-12-18', count: 1 },
    { date: '2023-12-19', count: 0 },
    { date: '2023-12-20', count: 4 },
    { date: '2023-12-21', count: 2 },
    { date: '2023-12-22', count: 1 },
    { date: '2023-12-23', count: 0 },
    { date: '2023-12-24', count: 3 }];
