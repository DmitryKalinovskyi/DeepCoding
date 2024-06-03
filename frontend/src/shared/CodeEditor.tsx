import React, {useEffect, useRef, useState} from "react";
import {EditorState} from "@codemirror/state"
import {EditorView, keymap, lineNumbers} from "@codemirror/view"
import {defaultKeymap} from "@codemirror/commands"
import {cpp} from "@codemirror/lang-cpp";
import {githubLight} from "@uiw/codemirror-theme-github";

export interface CodeEditorProps{
    className?: string;
    onChange?: (value: string) => void;
}

const CodeEditor =
    React.forwardRef<HTMLDivElement, CodeEditorProps>
    ((props, ref) => {
        const editorRef = useRef<HTMLDivElement | null>(null);
        const viewRef = useRef<EditorView | null>(null);

        const [code, setCode] = useState("")

        useEffect(() => {
            if (editorRef.current) {
                const startState = EditorState.create({
                    doc: code,
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
                    parent: editorRef.current
                });

                const handleEditorChange = () => {
                    if (props.onChange && viewRef.current) {
                        const value = viewRef.current.state.doc.toString();
                        setCode(value)
                        props.onChange(value); // Notify parent component of content change
                    }
                };

                viewRef.current.dom.addEventListener("input", handleEditorChange); // Attach blur event listener


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