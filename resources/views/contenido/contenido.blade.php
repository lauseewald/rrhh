@extends('principal')
@section('contenido')
<template v-if="menu==0">
    Inicio
</template>
<template v-if="menu==1">
    <empleado></empleado>
</template>
<template v-if="menu==2">
    contratos
</template>
<template v-if="menu==3">
    <incidencia></incidencia>
</template>

@endsection