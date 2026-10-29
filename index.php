<?php
$num1 = '';
$num2 = '';
$operator = '+';
$result = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs as floating-point numbers
    $num1_input = filter_input(INPUT_POST, 'num1', FILTER_VALIDATE_FLOAT);
    $num2_input = filter_input(INPUT_POST, 'num2', FILTER_VALIDATE_FLOAT);
    $operator = $_POST['operator'] ?? '+';

    // Retain form input values for display
    $num1 = $_POST['num1'] ?? '';
    $num2 = $_POST['num2'] ?? '';

    if ($num1_input === false || $num2_input === false) {
        $error = "Please enter valid numerical values.";
    } else {
        switch ($operator) {
            case '+':
                $result = $num1_input + $num2_input;
                break;
            case '-':
                $result = $num1_input - $num2_input;
                break;
            case '*':
                $result = $num1_input * $num2_input;
                break;
            case '/':
                if ($num2_input == 0) {
                    $error = "Division by zero is undefined.";
                } else {
                    $result = $num1_input / $num2_input;
                }
                break;
            case '%':
                if ($num2_input == 0) {
                    $error = "Modulo by zero is undefined.";
                } else {
                    $result = fmod($num1_input, $num2_input);
                }
                break;
            case '^':
                $result = pow($num1_input, $num2_input);
                break;
            default:
                $error = "Invalid operation selected.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Calculator</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        body {
            background-color: #f1f5f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .calculator-card {
            background: #ffffff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 380px;
        }
        h2 {
            color: #0f172a;
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.4rem;
            color: #475569;
            font-size: 0.875rem;
            font-weight: 600;
        }
        input, select, button {
            width: 100%;
            padding: 0.75rem;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            font-size: 1rem;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }
        button {
            background-color: #4f46e5;
            color: #ffffff;
            font-weight: 600;
            border: none;
            cursor: pointer;
            margin-top: 0.5rem;
            transition: background-color 0.2s;
        }
        button:hover {
            background-color: #4338ca;
        }
        .result-box {
            margin-top: 1.5rem;
            padding: 1rem;
            border-radius: 6px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            text-align: center;
        }
        .result-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 0.25rem;
        }
        .result-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
            word-break: break-all;
        }
        .error-msg {
            color: #b91c1c;
            background-color: #fef2f2;
            padding: 0.75rem;
            border-radius: 6px;
            border: 1px solid #fecaca;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>

<div class="calculator-card">
    <h2>PHP Calculator</h2>

    <?php if ($error): ?>
        <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="num1">First Number</label>
            <input type="number" step="any" id="num1" name="num1" value="<?= htmlspecialchars((string)$num1) ?>" required placeholder="Enter number">
        </div>

        <div class="form-group">
            <label for="operator">Operation</label>
            <select id="operator" name="operator">
                <option value="+" <?= $operator === '+' ? 'selected' : '' ?>>Addition (+)</option>
                <option value="-" <?= $operator === '-' ? 'selected' : '' ?>>Subtraction (-)</option>
                <option value="*" <?= $operator === '*' ? 'selected' : '' ?>>Multiplication (×)</option>
                <option value="/" <?= $operator === '/' ? 'selected' : '' ?>>Division (÷)</option>
                <option value="%" <?= $operator === '%' ? 'selected' : '' ?>>Modulo (%)</option>
                <option value="^" <?= $operator === '^' ? 'selected' : '' ?>>Exponentiation (^)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="num2">Second Number</label>
            <input type="number" step="any" id="num2" name="num2" value="<?= htmlspecialchars((string)$num2) ?>" required placeholder="Enter number">
        </div>

        <button type="submit">Calculate</button>
    </form>

    <?php if ($result !== null && !$error): ?>
        <div class="result-box">
            <div class="result-label">Result</div>
            <div class="result-value"><?= htmlspecialchars((string)$result) ?></div>
        </div>
    <?php endif; ?>
</div>

</body>
</html>