<x-guest-layout>
    <x-auth-split titulo="Datos del vehículo" subtitulo="Paso 5 de 5 · Vehículo">

        <ul class="steps w-full mb-6">
            <li class="step step-primary text-xs">Datos</li>
            <li class="step step-primary text-xs">Carnet</li>
            <li class="step step-primary text-xs">Selfie</li>
            <li class="step step-primary text-xs">Licencia</li>
            <li class="step step-primary text-xs">Vehículo</li>
        </ul>

        @if ($errors->any())
            <div role="alert" class="alert alert-error mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div role="alert" class="alert alert-info mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span class="text-sm">Declara el vehículo con el que realizarás los viajes.</span>
        </div>

        <form method="POST" action="{{ route('registro.vehiculo') }}" class="space-y-4">
            @csrf

            <div>
                <label class="label" for="placa">
                    <span class="label-text font-semibold">Placa</span>
                </label>
                <input id="placa" type="text" name="placa" value="{{ old('placa') }}"
                       class="input input-bordered w-full uppercase" placeholder="Ej. 1234-ABC" required>
            </div>

            <div>
                <label class="label" for="marca_modelo">
                    <span class="label-text font-semibold">Marca y modelo</span>
                </label>
                <input id="marca_modelo" type="text" name="marca_modelo" value="{{ old('marca_modelo') }}"
                       class="input input-bordered w-full" placeholder="Ej. Toyota Corolla 2018" required>
            </div>

            <div>
                <label class="label" for="relacion_declarada">
                    <span class="label-text font-semibold">Relación con el vehículo</span>
                </label>
                <select id="relacion_declarada" name="relacion_declarada" class="select select-bordered w-full" required>
                    <option value="propio" @selected(old('relacion_declarada') === 'propio')>Propio</option>
                    <option value="familiar" @selected(old('relacion_declarada') === 'familiar')>Familiar</option>
                    <option value="alquilado" @selected(old('relacion_declarada') === 'alquilado')>Alquilado</option>
                    <option value="otro" @selected(old('relacion_declarada') === 'otro')>Otro</option>
                </select>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('registro.licencia') }}" class="btn btn-ghost flex-1">Volver</a>
                <button type="submit" class="btn btn-primary flex-1">Finalizar registro</button>
            </div>
        </form>
    </x-auth-split>
</x-guest-layout>
