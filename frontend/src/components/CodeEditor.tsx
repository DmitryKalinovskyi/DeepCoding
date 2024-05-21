import React, {useEffect, useRef} from "react";
import {EditorState} from "@codemirror/state"
import {EditorView, keymap, lineNumbers} from "@codemirror/view"
import {defaultKeymap} from "@codemirror/commands"
import {cpp} from "@codemirror/lang-cpp";
import {githubLight} from "@uiw/codemirror-theme-github";

export interface CodeEditorProps{
    className?: string
}

const CodeEditor =
    React.forwardRef<HTMLDivElement, CodeEditorProps>
    ((props, ref) => {
        const editorRef = useRef<HTMLDivElement | null>(null);
        const viewRef = useRef<EditorView | null>(null);

        useEffect(() => {
            if (editorRef.current) {
                const startState = EditorState.create({
                    doc: "#include <iostream>\n" +
                        "\n" +
                        "using namespace std;\n" +
                        "void main(){\n" +
                        "  int a, b;\n" +
                        "  cin >> a >> b;\n" +
                        "  cout << a + b << endl;\n" +
                        "}",
                    extensions:
                        [
                            lineNumbers(),
                            keymap.of(defaultKeymap),
                            cpp(),
                            githubLight
                        ],
                });

                viewRef.current = new EditorView({
                    state: startState,
                    parent: editorRef.current,
                });

                return () => {
                    if (viewRef.current) {
                        viewRef.current.destroy();
                    }
                };
            }
        }, []);

        return (
            <div className={props.className} ref={ref}>
                <div className="h-full" ref={editorRef}/>
            </div>
        )
    })

export default CodeEditor;