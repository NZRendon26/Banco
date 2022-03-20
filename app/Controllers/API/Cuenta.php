<?php
namespace App\Controllers\API;

use App\Models\CuentaModel;
use CodeIgniter\RESTful\ResourceController;

class cuentas extends ResourceController
{

public function _construct(){
$this->model =$this->setModel(new CuentaModel());

}

public function index(){
 $cuentas = $this->model->findAll();
 return $this->respond($cuentas);

}

public function create()
    {
try {

$cuenta = $this->request->getJSON();

if($this->model->insert($cuenta)):
                $cuenta->id = $this->model->insertID();
                return $this->respondCreated($cuenta);
                else:
                    return $this->failValidationErrors($this->model->validation->listErrors());
            endif;

        }catch (\Exception $e){
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
      }

      public function edit( $id = null )
      {
        try {
         
          if ( $id == null ) {
            return $this->respond([
              'error' => 'No se pudo  editar esta cuenta'
            ], 500);
  
          } else {
  
            $cuenta = $this->model->find($id);
            if ( $cuenta ) {
              $cuenta = $this->request->getJSON();
              if ( $this->model->update($id, $cuenta) ) {
                return $this->respond([
                  'msg' => 'La cuenta se edito correctamente',
                  'cuenta' => $cuenta],
                  200);
              } else {
                return $this->respond(
                  ['error' => 'No se puede editar  esta cuenta'],
                  500);
              }
            } else {
              return $this->respond(
                ['error' => 'La cuenta no esta disponible'],
                500);
            }
          }
        } catch (\Exception $e) {
          //Exception $e;
          return $this->failServerError('Error en el servidor', $e->getMessage());
        }
      }
        public function update($id = null)
        {
            try {
    
                if($id == null)
                    return $this->failValidationErrors('No se ha la cuenta');
                
                    $cuentaVerificado = $this->model->find($id);
    
                if($cuentaVerificado == null)
                return $this->failNotFound('No se ha encontrado la cuenta de este cliente:'.$id);
    
                $cuenta = $this->request->getJSON();
    
                if($this->model->update($id, $cuenta)):
                    $cuenta->id = $id;
                    return $this->respondUpdated($cuenta);
                    else:
                        return $this->failValidationErrors($this->model->validation->listErrors());
                endif;
    
    
            }catch (\Exception $e){
                return $this->failServerError('ha ocurrido un error en el servidor');
            }
        } 
    
        public function delete($id = null)
    {
      try {
        //code...
        if ( $id == null ) {
          return $this->respond(
            ['error' => 'No se pudo eliminar esta cuenta'],
            500);
        } else {
          $cuenta = $this->model->find($id);
          if ( $cuenta ) {
            if ( $this->model->delete($id) ) {
              return $this->respond([
                'msg' => 'La cuenta se elimino ',
                'cuenta' => $cuenta
              ], 200);

            } else {
              return $this->respond([
                'error' => 'No se puede eliminar esta cuenta'
              ], 500);
            }
          } else {
            return $this->respond([
              'error' => 'Esta cuenta no se encuentra o no existe'
            ], 500);
          }
        }
      } catch (\Exception $e) {
        //Exception $e;
        return $this->failServerError('Error en el servidor', $e->getMessage());
      }
    }



    }










