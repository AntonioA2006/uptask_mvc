document.addEventListener('DOMContentLoaded',()=>{
App.Iniciar();
}); 
let tareas = [];
let filters = [];
const App = (function(){
    return {
        Iniciar:function () {
            Modal.MostrarModal();
            ApiHandlerShow();
            FilterTasks.index();
        },
        ShowAlert:function(msg, tipo){
           
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
            
              
                switch (tipo) {
                    case 'success':
                        toastr.success(msg);
                        break;
                    case 'error':
                        toastr.error(msg);
                        break;
                    case 'info':
                        toastr.info(msg);
                        break;
                    case 'warning':
                        toastr.warning(msg);
                        break;
                    default:
                        console.warn('Tipo de alerta desconocido:', tipo);
                        toastr.info(msg);
                        break;
                }
            }
        
    }
})()

const FilterTasks = (function(){
    function AddEventEachElement(){
        const filtros = document.querySelectorAll('#filtros input[type="radio"]');

        
        filtros.forEach((element)=>{
            element.addEventListener('input',(e)=>{
                filterTask(e);
            })
        });
    }
    function filterTask(e){
        
        const filtro = e.target.value;
        
        if (filtro !== "") {
            filters = tareas.filter(tarea => tarea.estado === filtro);
        }else{
            filters = [];
        }
        ShowTasks.index();
    }
    
    
    
    return {
        index:function(){
            AddEventEachElement();
        }
        
        
    }
})()





const Modal = (function(){
        const nuevaTareaBtn = document.querySelector('#agregar-tarea');
        nuevaTareaBtn.addEventListener('click', ()=>{
            mostrarFormulario()
        });
        function mostrarFormulario(event = false, tarea = {}){
           
            
            const modal = document.createElement("DIV");
            modal.classList.add('modal');
            modal.innerHTML = `
           <form class="formulario nueva-tarea">
                     <legend>${event ? 'Editar tarea': "crea una nueva tarea"}</legend>
                <div class="campo">
                    <label for="tarea">Tarea</label>
                    <input type="text" name="tarea" id="tarea" placeholder="${tarea.nombre ? 'edita la tarea' : 'nueva tarea'}" value="${tarea.nombre ? tarea.nombre : ''}">
                </div>
                <div class="opciones">
                <input type="submit" value="${tarea.nombre ? 'edita la tarea' : 'nueva tarea'}" class="submit-nueva-tarea">
                <button type="button" class="cerrar-modal">Cancelar</button>
                </div>

        </form>
            `
            setTimeout(() => {
                    const formulario = document.querySelector('.formulario');
                    formulario.classList.add('animar');
            }, 0);
            modal.addEventListener("click", (e)=>{
                e.preventDefault();
                
                if (e.target.classList.contains('cerrar-modal')) {
                    const formulario = document.querySelector('.formulario');
                    formulario.classList.add('cerrar');
                    setTimeout(() => {        
                        modal.remove();
                    }, 500);
                    
                }
                if (e.target.classList.contains('submit-nueva-tarea')) {
                   
                        nuevaTarea(event, tarea);
                }


            });


            document.querySelector('body').appendChild(modal);
            
         }
         function nuevaTarea(e,tarea){
            const nombreTarea = document.querySelector("#tarea").value.trim();
            if (nombreTarea === '') {
                  App.ShowAlert('El nombre de la tarea es obligatorio', 'error' )  ;
                  return 
            }
            if (e === false) {
                     
               ApiHandlerCreate(nombreTarea);
                //pasar la tarea ala API  
                return 
            }else{
                tarea.nombre = nombreTarea;
               ApiHandlerChageTask.index(tarea);
            }   
            //actuliazxar la tarea desdela API



         }
       
    return{
        index:(e, t)=>{
            mostrarFormulario(e, t);
        },
        MostrarModal:function () {

        }

    }


})();



const getProject = (function(){

    const projectParams  = new URLSearchParams(window.location.search);
    const proyecto = Object.fromEntries(projectParams.entries());
    const {id} = proyecto
    return {
        get:function(){
            return id;
        }
    }
})()

const ApiHandlerCreate = (function (){
       

    const url = 'http://localhost:8080/api/tarea';
    const datos = new FormData();
    return async (e)=>{
        datos.append('nombre',e)
        datos.append('proyecto_id',getProject.get());
        try {   
          const respuesta = await fetch(url,{
            method : "POST",
            body : datos
        });
        const resultado = await respuesta.json();
        const {id,tipo, mensaje, exito, proyecto_id} = resultado;
        if (exito == 'false') {
            App.ShowAlert(mensaje,tipo)
        }else{
            App.ShowAlert(mensaje,tipo)
            const modal = document.querySelector('.modal');

            setTimeout(() => {
                modal.remove();  
            }, 2500);

            const tareaObj = {
                id: id.toString(),
                nombre: e,
                estado: "0",
                proyecto_id : proyecto_id
            }
            tareas = [...tareas,tareaObj];
            ShowTasks.index();
        }   

       
        } catch (error) {
            console.log(error);
        }
    }
    

})()
const ApiHandlerShow = (function (){
    const url = `/api/tareas?id=${getProject.get()}`;
    
    
    return async ()=>{
        try {
            const respuesta  = await fetch(url);
            const resultado = await respuesta.json();
           
            tareas = resultado.tareas;

           ShowTasks.index();
        } catch (error) {
            console.log(error)
        }
     }   
})()

const ShowTasks = (function(){
    const texto = document.createElement("LI");
    const listadoTareas = document.querySelector('#listado-tareas');
    
    function clearHTML (){
        while (listadoTareas.firstChild) {
                listadoTareas.removeChild(listadoTareas.firstChild);
        }
    }
    function totalPendientes(){
        const totalPendientes = tareas.filter(tarea => tarea.estado === '0');
        const pedientesRadio = document.querySelector("#pendientes");
        if (totalPendientes.length === 0 ) {
                pedientesRadio.disabled = true;
        }else{
            pedientesRadio.disabled = false;
        }

    }
    function totalCompletas(){
        const totalCompletas = tareas.filter(tarea => tarea.estado === '1');
        const completas = document.querySelector("#completadas");
        if (totalCompletas.length === 0 ) {
                completas.disabled = true;
        }else{
            completas.disabled = false;
        }

    }

    const estados = {
         0:'pendiente',
          1:'completa'
    }
    return {
        index:function(){
            clearHTML()
            totalPendientes();
            totalCompletas();
            const arrayTareas = filters.length? filters : tareas;
            if (arrayTareas.length == 0) {
                    texto.textContent = 'No hay tareas';
                    texto.classList.add('no-tareas');

                    listadoTareas.appendChild(texto);
                    return 
            }
            arrayTareas.forEach(element => {
                const contenedorTask = document.createElement("LI");
                contenedorTask.dataset.tareaId = element.id;
                contenedorTask.classList.add('tarea');

                const nombreTarea = document.createElement('P');
                nombreTarea.textContent = element.nombre;
                nombreTarea.ondblclick =  ()=>{
                    Modal.index(true, {...element});
                };


                const opcionesDiv = document.createElement('DIV');
                opcionesDiv.classList.add('opciones');

                const btnEstadoTarea = document.createElement('BUTTON');
                btnEstadoTarea.classList.add('estado-tarea');
                btnEstadoTarea.classList.add(`${estados[element.estado].toLowerCase()}`)
                btnEstadoTarea.textContent = estados[element.estado];
                btnEstadoTarea.dataset.estadoTarea = element.estado;
                btnEstadoTarea.ondblclick = ()=>{
                    ApiHandlerChageTask.index({...element})
                };
                
                const btnEliminarTarea = document.createElement('BUTTON');
                btnEliminarTarea.classList.add('eliminar-tarea');
                btnEliminarTarea.dataset.idTarea = element.id; 
                btnEliminarTarea.textContent = 'Eliminar';
                btnEliminarTarea.ondblclick = ()=>{
                    ApiHnadlerDeleteTask.index ({...element});
                }


                opcionesDiv.appendChild(btnEstadoTarea);
                opcionesDiv.appendChild(btnEliminarTarea);
                
                contenedorTask.appendChild(nombreTarea);
                contenedorTask.appendChild(opcionesDiv);

                const listadoTareas = document.querySelector("#listado-tareas");
                listadoTareas.appendChild(contenedorTask);
            });
        }   
    }
})()
const ApiHnadlerDeleteTask = (function(){
    async function DeleteTask(params) {
        const {estado, id, nombre} = params;
        const datos = new FormData();
        datos.append('id',id);
        datos.append('estado',estado);
        datos.append('nombre',nombre);
        datos.append('proyecto_id',getProject.get());
        const url = '/api/tarea/eliminar';
       try {
        const respuesta = await fetch(url,{
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();
        tareas = tareas.filter(element => element.id !== id)
        ShowTasks.index();



         return resultado
       } catch (error) {
            console.log(error);
       }
    } 



    return {
        index:function (task){
            Swal.fire({
                title: "Estas Seguro?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "si borra la tarea"
              }).then((result) => {
                if (result.isConfirmed) {
                    DeleteTask(task)
                    .then(result => {
                        const {tipo,mensaje} = result
                        Swal.fire({
                            title:mensaje,
                            icon:tipo
                          });
                    })
                }
             });
        }   
    }


})()
const ApiHandlerChageTask = (function(){
  async function ChageTaskEstate(element){
    

        const {estado, id, nombre} = element;
        const datos = new FormData();
        datos.append('id',id);
        datos.append('estado',estado);
        datos.append('nombre',nombre);
        datos.append('proyecto_id',getProject.get());
        try {
            const url = '/api/tarea/actualizar'
            const respuesta = await fetch(url,{
                method: "POST",
                body: datos
            }) ;
            const resultado = await respuesta.json();
            const {tipo, mensaje, exito} = resultado;

            if (exito == 'true') { 
                App.ShowAlert(mensaje,tipo);
                const modal = document.querySelector('.modal');
                if (modal) {
                    
                    modal.remove();  
                }

                tareas = tareas.map(e => {
                    if (e.id === id) {
                        e.estado = estado
                        e.nombre = nombre
                    }
                    return e;
                });
               
              
    
                ShowTasks.index();
            }

           



        } catch (error) {
                console.log(error);
        }
    }

    return {
            index:function(e){
                const nuevoEstado = e.estado == '1' ? '0': '1';
                e.estado = nuevoEstado;
                    ChageTaskEstate(e)
            }    
    }
})()