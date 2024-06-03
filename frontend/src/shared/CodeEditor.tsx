import React, {useEffect, useRef, useState} from "react";
import {EditorState} from "@codemirror/state"
import {EditorView, keymap, lineNumbers} from "@codemirror/view"
import {defaultKeymap} from "@codemirror/commands"
import {python} from "@codemirror/lang-python";
import {githubLight} from "@uiw/codemirror-theme-github";
import useLocalStorage from "../hooks/useLocalStorage.ts";

export interface CodeEditorProps{
    className?: string;
    onChange?: (value: string) => void;
    storageId: string;
}

function getDefaultCodeTemplate() {
    return `"#import required libraries\\nimport math\\n\\ndef read_input():\\n  with open(\\\"input.txt\\\", \\\"r\\\") as input_txt:\\n    return input_txt.readlines()\\n\\nlines = read_input()\\n\\nname = lines[0];\\n\\nprint(\\\"My name is \\\" + name)\\n"`;
}



const CodeEditor =
    React.forwardRef<HTMLDivElement, CodeEditorProps>
    ((props, ref) => {
        const editorRef = useRef<HTMLDivElement | null>(null);
        const viewRef = useRef<EditorView | null>(null);
        const [code, setCode] = useLocalStorage(props.storageId, getDefaultCodeTemplate())
        // const [code, setCode] = useState("");
        useEffect(() => {
            if (editorRef.current) {
                const startState = EditorState.create({
                    doc: code,
                    extensions:
                        [
                            lineNumbers(),
                            keymap.of(defaultKeymap),
                            python(),
                            githubLight
                        ],
                });

                viewRef.current = new EditorView({
                    state: startState,
                    parent: editorRef.current,
                    dispatch: (tr) => {
                        if (tr.docChanged) {
                            const value = tr.newDoc.toString();
                            props.onChange && props.onChange(value); // Notify parent component of content change
                            setCode(value); // Update local storage
                        }
                        viewRef.current?.update([tr]);
                    },
                });

                // Notify parent component with initial value on mount
                props.onChange && props.onChange(code);

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