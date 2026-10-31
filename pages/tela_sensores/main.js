const criar = document.getElementById('criar_sensor');
const sensor = document.getElementById('sensor');

criar.addEventListener('click', () => {

    fetch("../../assets/html/criar_sensor.php")
        .then(resposta => resposta.text())
        .then(html => {

            sensor.innerHTML = html;

            const btn_fechar = document.getElementById('fechar_conta');

            btn_fechar.addEventListener('click', () => {
                sensor.innerHTML = '';
            });
        });
})