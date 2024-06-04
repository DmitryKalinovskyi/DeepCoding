import Card from "@mui/material/Card";
import SearchFilter from "./SearchFilter.tsx";
import DynamicLayout from "../../widgets/layout/DynamicLayout.tsx";

function Problems(){
    return (
        <DynamicLayout>
            <Card className="p-4">
            <SearchFilter pageSize={25}/>
            </Card>
        </DynamicLayout>
    )
}

export default Problems;