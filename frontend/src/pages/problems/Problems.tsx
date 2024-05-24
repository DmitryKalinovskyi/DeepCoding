import Card from "@mui/material/Card";
import ProblemsFilter from "./SearchFilter.tsx";
import DynamicLayout from "../../partial-pages/layout/DynamicLayout.tsx";

function Problems(){
    return (
        <DynamicLayout>
            <Card className="p-4">
            <ProblemsFilter pageSize={25}/>
            </Card>
        </DynamicLayout>
    )
}

export default Problems;