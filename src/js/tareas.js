document.addEventListener('DOMContentLoaded',()=>{
App.Iniciar();
}); 


const App = (function(){
    return {
        Iniciar:function () {
            Modal.MostrarModal();
        }
    }
})()

const Modal = (function(){
        const nuevaTareaBtn = document.querySelector('#agregar-tarea');
        nuevaTareaBtn.addEventListener('click', mostrarFormulario)
        function mostrarFormulario(){
            const modal = document.createElement("DIV");
            modal.classList.add('modal');
            modal.innerHTML = `
           <form class="formulario nueva-tarea">
                     <legend>Crea una nueva tarea</legend>
                <div class="campo">
                    <label for="tarea">Tarea</label>
                    <input type="text" name="tarea" id="tarea" placeholder="nueva tarea">
                </div>
                <div class="opciones">
                <input type="submit" value="Crear tarea" class="submit-nueva-tarea">
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
                        nuevaTarea();
                }


            });


            document.querySelector('body').appendChild(modal);
            
         }
         function nuevaTarea(){
            const tarea = document.querySelector("#tarea").value.trim();
            if (tarea === '') {
                  mostrarAlerta('El nombre de la tarea es obligatorio', 'Error', )  ;
                  return 
            }

         }
         function mostrarAlerta(msg, tipo){
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
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
              }
            toastr.error(msg, tipo);
         }
    return{
        MostrarModal:function () {
                
        }
    }


})();