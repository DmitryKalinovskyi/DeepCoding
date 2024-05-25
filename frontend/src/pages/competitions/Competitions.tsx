import DynamicLayout from "../../partial-pages/layout/DynamicLayout.tsx";
import CompetitionWidget from "./CompetitionWidget.tsx";

export default function Competitions(){
    return (
        <DynamicLayout>
            <div className="mb-10">
                <div className="font-semibold text-xl">
                    Active competitions
                </div>
            </div>

            <div className="flex flex-col gap-2">
                <CompetitionWidget id={0}/>
                <CompetitionWidget id={1}/>
                <CompetitionWidget id={2}/>
            </div>
        </DynamicLayout>
    )
}