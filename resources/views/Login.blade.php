<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login-Laravel</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.busnny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        .blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: linear-gradient(180deg, rgba(47, 184, 255, .42) 31.77%, #d400db 100%);
            border-radius: 24% 76% 35% 65% / 27% 36% 64% 73%;
            filter: blur(50px) z-index: -1;
            transition: 1s cubic-bezier(.07, .8, .16, 1);
        }

        .blob:hover {
            width: 520px;
            height: 520px;
            filter: blur(30px);
            box-shadow:
                inset 0 0 0 5px rgba(255, 255, 255, .6),
                inset 100px 100px 0 0 #fa709a,
                inset 100px 100px 0 0 #784ba8,
                inset 100px 100px 0 0 #2b86c5,
        }
    </style>

</head>

<body class="bg-slate-500 min-h-screen flex items-center justify-center p-5 overflow-hidden">
    <div id="blob" class="blob"></div>
    <div id="login-container"
        class="opacity-0 bg-white/70 backdrop-blur-md flex items-center justify-center border border-white/20 shadow-2xl p-5 rounded-2xl w-full max-w-[350px]">
        <form id="form" class="flex flex-col items-center space-y-5">
            @csrf
            <h2 class="font-bold text-2xl text-center tracking-tight uppercase">
                Login
            </h2>
            <div class="field-anim flex w-full h-full items-center justify-center  gap-2">
                <a href="{{ route('login-google') }}" type="button" class=" bg-black text-white rounded-full p-3 h-full w-full cursor-pointer flex items-center justify-center gap-2 hover:bg-white/50 hover:text-black transition">
                    <ion-icon name="logo-google"></ion-icon>
                    Login with Google
                </a>
            </div>


            <div class="field-anim relative w-full">
                <span class="icon absolute left-3 top-1/2 -translate-y-1/2 text-xl">
                    <ion-icon name="mail-outline"></ion-icon>
                </span>
                <input placeholder="Email" required type="email" name="email"
                    class="w-full pl-10 pr-5 py-3 bg-white/50 border border-slate-200 rounded-md focus:ring-4 focus:ring-indigo-200 focus:border-indigo-200
                outline-none transition-all placeholder:text-slate-400">
            </div>

            <div class="field-anim relative w-full">
                <span class="icon absolute left-3 top-1/2 -translate-y-1/2 text-xl">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                </span>
                <input placeholder="Password" type="password" name="password"
                    class="w-full pl-10 pr-5 py-3 bg-white/50 border border-slate-200 rounded-md focus:ring-4 focus:ring-indigo-200 focus:border-indigo-200
                outline-none transition-all placeholder:text-slate-400">
            </div>

            <div class="flex flex-wrap items-center justify-between text-sm font-thin gap-4">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                    <input type="checkbox"
                        class="w-4 h-4 rounded text-indigo-600 border-slate-300 focus:ring-indigo-500">
                    Recuerdame
                </label>
                <a href="{{ route('forgot-password') }}" class="text-indigo-600 hover:text-indigo-800 hover:underline transition">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>

            <button type="submit" id="login-btn"
                class="w-full bg-indigo-600 text-white py-3 rounded-md font-md shadow-lg shadow-indigo-200 
            hover:bg-indigo-700 active:scale-95 transition-all cursor-pointer">
                Iniciar Sesión
            </button>

            <div class="flex flex-row gap-2 text-sm font-thin">
                <p class="text-slate-600">¿No tienes una cuenta?</p>
                <a href="{{ route('register') }}"
                    class="text-indigo-600 hover:text-indigo-800 hover:underline transition">Regístrate</a>
            </div>
        </form>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

    <script>
        const form = document.getElementById('form');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(e.target);

            try {
                const response = await fetch('/api/login', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                    }
                });

                const result = await response.json();

                if(response.ok && result.status) {
                    window.location.href = '/dashboard';
                }else{
                    alert(result.message || 'Error con las credenciales al inicar sesión');
                }

            } catch (error) {
                console.error('Error: ', error);
            }
        });
    </script>

    <script>
        console.log('Script Funcionando');
        document.addEventListener('DOMContentLoaded', () => {
            anime({
                targets: '#login-container',
                translateY: [50, 0],
                opacity: [0, 1],
                duration: 1000,
                easing: 'easeOutExpo'
            });

            anime({
                targets: '.blob',
                translateX: [{
                        value: 200,
                        duration: 3000,
                        easing: 'easeInOutQuad'
                    },
                    {
                        value: -200,
                        duration: 3000,
                        easing: 'easeInOutQuad'
                    },
                    {
                        value: 0,
                        duration: 3000,
                        easing: 'easeInOutQuad'
                    }
                ],
                translateY: [{
                        value: -100,
                        duration: 2500,
                        easing: 'easeInOutQuad'
                    },
                    {
                        value: 100,
                        duration: 2500,
                        easing: 'easeInOutQuad'
                    },
                    {
                        value: 0,
                        duration: 2500,
                        easing: 'easeInOutQuad'
                    }
                ],
                loop: true,
                direction: 'alternate'
            });

            anime({
                targets: '.field-anim',
                scale: [0.9, 1],
                opacity: [0, 1],
                delay: anime.stagger(150, {
                    start: 500
                }),
                easing: 'easeOutBack'
            })

        });
    </script>
</body>

</html>
