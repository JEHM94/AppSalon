function iniciarApp(){mostrarFecha(),buscarPorFecha(),alertaEliminarCita()}function mostrarFecha(){const e=document.querySelector("#fecha").value,t=new Date(e),a=t.getMonth(),n=t.getDate()+2,i=t.getFullYear(),o=new Date(Date.UTC(i,a,n)).toLocaleDateString("es-MX",{weekday:"long",year:"numeric",month:"long",day:"numeric"}),r=document.createElement("H4");r.innerHTML=o,document.querySelector(".formulario").appendChild(r)}function buscarPorFecha(){document.querySelector("#fecha").addEventListener("input",(function(e){const t=e.target.value;t&&(window.location="?fecha="+t)}))}function alertaEliminarCita(){document.querySelectorAll(".boton-eliminar").forEach(e=>{const t=e.id;e.addEventListener("click",(function(){Swal.fire({title:`¿Está seguro que desea eliminar la Cita ID: ${t}?`,text:"¡No Podrá deshacer esta acción!",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Si, Eliminar.",cancelButtonText:"Cancelar"}).then(e=>{e.isConfirmed&&eliminarCita(t)})}))})}async function eliminarCita(e){const t=new FormData;t.append("citaId",e);try{const e=await fetch("http://127.0.0.1:3000/api/eliminar",{method:"POST",body:t});(await e.json()).resultado?Swal.fire({icon:"success",title:"¡Eliminado!",text:"La cita ha sido eliminada exitosamente."}).then(()=>{window.location.reload()}):Swal.fire({icon:"error",title:"Oops...",text:"Ha ocurrido un error al eliminar la cita. Por favor, intentelo más tarde."})}catch(e){Swal.fire({icon:"error",title:"Oops...",text:"Ha ocurrido un error al eliminar la cita. Por favor, intentelo más tarde."})}}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));