# El "2" en Vagrant.configure establece la versión de configuración (hasta el momento "1" y "2")
Vagrant.configure("2") do |config|

  # Establecemos la imágen base o `box` para nuestra maquina virtual, se trata de la imagen
  # oficial de ubuntu 18.04 LTS.
  config.vm.box = "ubuntu/bionic64"

  # Configuramos la ip que queremos que tenga nuestra máquina para luego indicársela en su
  # inventario a ansible y poder acceder desde el exterior a través de esta ip.
  config.vm.network :private_network, ip: "192.168.111.222"
  # Creamos un mapeo de puertos desde la máquina virtual al anfitrión. En este caso, cuando
  # accedamos a, por ejemplo, "localhost:8080" estaremos accediendo al puerto 8080 de la máquina
  # invitada.
  config.vm.network "forwarded_port", guest: 8080, host: 8080

  # Aquí va la configuración específica del provider que en este caso se ha elegido virtualbox por ser
  # el que funciona por defecto con vagrant.
  config.vm.provider "virtualbox" do |virtualbox|
    
    # Establecemos la cantidad de memoria asignada a la VM:
    virtualbox.memory = "1024"
  end

  # Configuración específica para el provisioner en el cuál se ha usado ansible como herramienta.
  config.vm.provision :ansible do |ansible|
    # configuración para decirle a ansible que nos diga todo lo que está haciendo (no es imprescindible).
    ansible.verbose = "-vv"
    # indicamos la ruta al inventario donde se encuetran los hosts.
    ansible.inventory_path = "provisioning/hosts.yml"
    # indicamos la ruta al playbook que queremos que se ejecute.
    ansible.playbook = "provisioning/provision.yml"
  end
end
