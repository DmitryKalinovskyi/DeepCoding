
function CodeEditor(){
    return (
        <form className="h-100" method="post">

            <div className="d-flex flex-column h-100">
                <div className="bg-light rounded-2">
                    <div className="input-group mb-2">
                        <div className="input-group-text">
                            Select your compiler:
                        </div>
                        <select className="form-control" name="compiler">
                            <option>C</option>
                            <option>C++</option>
                        </select>
                    </div>
                </div>

                <textarea name="code" placeholder="Enter your code here..." className="form-control editor-area flex-grow-1 mb-2">c++</textarea>
                <input name="problemId" value="<?php echo $problem->Id ?> " hidden/>
                    <div>
                        <button className="btn btn-primary" type="submit">Send</button>
                    </div>
            </div>
        </form>
    )
}

export default CodeEditor;