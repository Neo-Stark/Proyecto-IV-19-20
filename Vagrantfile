# El "2" en Vagrant.configure establece la versión de configuración (hasta el momento "1" y "2")
Vagrant.configure("2") do |config|

  # Establecemos la imágen base o `box` para nuestra maquina virtual, se trata de una 
  # dummy-box específica para azure donde posteriormente instalaremos en azure el SO 
  # que necesitemos
  config.vm.box = "azure"

  # use local ssh key to connect to remote vagrant box
  config.ssh.private_key_path = '~/.ssh/id_rsa'
  # Configure the Azure provider
  config.vm.provider 'azure' do |az|
    # Obtener los siguientes parámetros con la herramienta cli az de azure y exportarlos 
    # como variables de entorno para trabajar con ellas.
    az.tenant_id = ENV['AZURE_TENANT_ID']
    az.client_id = ENV['AZURE_CLIENT_ID']
    az.client_secret = ENV['AZURE_CLIENT_SECRET']
    az.subscription_id = ENV['AZURE_SUBSCRIPTION_ID']

    # Parametros específicos de las máquinas virtuales, COMUNES a la base de datos y la aplicación
    # Tipo de máquina virtual (características)
    az.vm_size = 'Standard_B1s'
    # Imagen que usaremos como SO, en este caso la última versión de Ubuntu 18.04 LTS
    az.vm_image_urn = 'Canonical:UbuntuServer:18.04-LTS:latest'
    # Localización del servidor
    az.location='westeurope'
    # Nombre del grupo de recursos donde agrupar las máquinas
    az.resource_group_name = 'vagrant'
  end # config.vm.provider 'azure'
  
  # Configuración específica para la aplicación web
  config.vm.define :web do |web|
    web.vm.provider 'azure' do |azWeb|
      # Nombre de la máquina virtual
      azWeb.vm_name = 'printcloud-final'
    end
    web.vm.provision :ansible do |ansibleWeb|
      # indicamos la ruta al playbook que queremos que se ejecute.
      ansibleWeb.playbook = "provisioning/printcloud.yml"
    end  
  end
  
  config.vm.define :db do |db|
    db.vm.provider 'azure' do |azDB|
      # Nombre de la máquina virtual
      azDB.vm_name = 'printcloud-final-db'
    end
    db.vm.provision :ansible do |ansibleDB|
      # indicamos la ruta al playbook que queremos que se ejecute.
      ansibleDB.playbook = "provisioning/db.yml"
    end  
  end
end
