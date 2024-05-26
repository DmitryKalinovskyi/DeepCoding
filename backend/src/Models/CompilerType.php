<?php

namespace DeepCode\Models;

enum CompilerType: string
{
    case C = "C";
    case C14 = "GNU C++ 14";
    case C17 = "GNU C++ 17";
}