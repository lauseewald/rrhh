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
<template v-if="menu=='evento'">
    <evento></evento>
</template>
<template v-if="menu=='departamento'">
    <departamento></departamento>
</template>
<template v-if="menu=='area'">
    <areal></areal>
</template>
<template v-if="menu=='empresa'">
    <empresa></empresa>
</template>
<template v-if="menu=='dianolaboral'">
    <dianolaboral></dianolaboral>
</template>
<template v-if="menu=='inasistencia'">
    <inasistencia></inasistencia>
</template>

@endsection