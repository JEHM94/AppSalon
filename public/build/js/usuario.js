function iniciarApp(){mostrarFecha(),alertaEliminarCita()}function mostrarFecha(){document.querySelectorAll("#fecha").forEach(e=>{const t=new Date(e.textContent),n=t.getMonth(),a=t.getDate()+2,o=t.getFullYear(),r=new Date(Date.UTC(o,n,a)).toLocaleDateString("es-MX",{weekday:"long",year:"numeric",month:"long",day:"numeric"});e.textContent=r})}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));