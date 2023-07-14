<script src="{{ asset('assets/js/jquery-3.6.1.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/pt-BR.js') }}"></script>
<script src="{{ asset('assets/js/jquery.mask.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.js') }}"></script>

@stack('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    $(document).ready(function() {
        @if (auth()->user())
            var nome = "{{ auth()->user()->nome }}";
        @else
            var nome = '';
        @endif

        nome = nome.toUpperCase();
        //pegar o primeiro e o ultimo nome
        var nome = nome.split(' ');
        var primeiroNome = nome[0];
        var ultimoNome = nome[nome.length - 1];
        var usuario = primeiroNome + ' ' + ultimoNome;

        var iniciais = usuario.match(/\b(\w)/g);
        var iniciaisNome = iniciais.join('');
        $('#img_perfil span').text(iniciaisNome);

        var color = generateColor(usuario);
        $('#img_perfil').css('background-color', color);

        function generateColor(nome = 'semnome') {
            let colors = {
                'a': '0',
                'b': '1',
                'c': '2',
                'd': '3',
                'e': '4',
                'f': '5',
                'g': '6',
                'h': '7',
                'i': '8',
                'j': '9',
                'k': 'A',
                'l': 'B',
                'm': 'C',
                'n': 'D',
                'o': 'E',
                'p': 'F',
                'q': '0',
                'r': '1',
                's': '2',
                't': '3',
                'u': '4',
                'v': '5',
                'w': '6',
                'x': '7',
                'y': '8',
                'z': '9',
            }
            let newName = nome.replaceAll(' ', '').toLowerCase();
            let color = '#';

            for (let i = 0; i < 6; i++) {
                if (newName[i] === undefined) {
                    color += '0';

                } else {
                    color += colors[newName[i]];
                }
            }
            return color;
        }
    });
</script>
</body>

</html>
