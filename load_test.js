import http from 'k6/http';
import { sleep } from 'k6';

export let options = {
    stages: [
        { duration: '30s', target: 10 }, // 10 usuarios en 30 segundos
        { duration: '1m', target: 50 },  // Aumenta a 50 usuarios en 1 minuto
        { duration: '30s', target: 0 },  // Reduce a 0 usuarios
    ],
};

export default function () {
    let res = http.get('http://localhost'); // Cambia por la URL de tu aplicación
    check(res, {
        'status es 200': (r) => r.status === 200,
        'tiempo de respuesta < 200ms': (r) => r.timings.duration < 200,
    });
    sleep(1); // Pausa de 1 segundo entre peticiones
}
