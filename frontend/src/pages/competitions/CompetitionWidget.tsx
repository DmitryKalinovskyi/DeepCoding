import Card from "@mui/material/Card";
import {Button} from "@mui/material";

async function fetchCompetition(){

}

interface CompetitionWidgetProps{
    id: number
}


export default function CompetitionWidget(props: CompetitionWidgetProps){
    return (
        <Card className="h-20 p-2 flex items-center gap-4">
            <div>
                <div className="text-xl">Competition {props.id}</div>
                <div>May 19</div>
            </div>
            <Button className="h-8" variant="contained">Join</Button>
        </Card>
    )
}