<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra de Créditos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 40px;
            margin-bottom: 20px;
        }

        .credit-box {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 200px;
        }

        .credit-box p {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .buy-button,
        .home-button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }

        .home-button {
            display: block;
            margin: 20px auto;
            width: 200px;
            background-color: #007bff;
        }

        .buy-button:hover,
        .home-button:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <form action="/creddits" method="post">
        <div class="container">
            <div class="credit-box">
                <p>2500 Créditos</p>
                <button class="buy-button" type="submit" value="2500" name="creddits">Comprar</button>
            </div>
            <div class="credit-box">
                <p>5000 Créditos</p>
                <button class="buy-button" type="submit" value="5000" name="creddits">Comprar</button>
            </div>
            <div class="credit-box">
                <p>10000 Créditos</p>
                <button class="buy-button" type="submit" value="10000" name="creddits">Comprar</button>
            </div>
            <div class="credit-box">
                <p>50000 Créditos</p>
                <button class="buy-button" type="submit" value="50000" name="creddits">Comprar</button>
            </div>
        </div>
    </form>
    <form action="/" method="get">
        <button class="home-button" type="submit">Volver a Home</button>
    </form>
</body>

</html>