@extends('principal')
@section('contenido')
<template v-if="menu==0">
    Inicio
</template>
<template v-if="menu==1">
    <empleado></empleado>
</template>
<template v-if="menu==2">
    <contrato></contrato>
</template>
<template v-if="menu==3">
    <incidencia></incidencia>
</template>
<template v-if="menu=='puesto'">
    <puesto></puesto>
</template>

@endsection