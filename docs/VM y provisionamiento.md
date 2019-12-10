# VM y provisionamiento

## Creación de la VM con Vagrant

Para crear la VM se ha usado __Vagrant__ junto con __Virtualbox__ por ser el proveedor con el que más experiencia tengo y con el que me siento más cómodo (además de ser libre (aunque pertenezca a 😈Oracle)). Se ha usado Vagrant porque a partir de un fichero nos permite configurar todo lo que necesitamos para preparar nuestra máquina, desde la imagen base que queremos usar hasta el _provisioner_.

El fichero en cuestión llamado __Vagrantfile__ es el siguiente:

```ruby
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
```

Se ha usado ubuntu como imágen base porque es la que se viene usando a lo largo de todo el proyecto y es la que seguro se con certeza que posee todos los paquetes que necesito para hacer funcionar la aplicación. Por otra parte, se ha optado por la versión _18.04 LTS_ por ser una versión estable del sistema y además, ser la última.

Para levantar la máquina solo bastará con utilizar la orden `composer vm-up` que llamará a `vagrant up` y ejecutará el fichero anterior y levantará la máquina.

## Aprovisionando la máquina usando ansible

Para aprovisionar la VM se ha optado por usar __ansible__ por ser una de las herramientas más extendidas en los últimos años. En nuestro caso, hemos creado un directorio _provisioning_ donde hemos creado a su vez dos ficheros, uno para el inventario __hosts.yml__ y otro con el playbook __provision.yml__ con el siguiente contenido:

```yml
---
  # indicamos el grupo que hemos definido en nuestro inventario provisioning/hosts.yml
- hosts: default
  become: yes

  # declaramos la variable installer por comodidad para usarla en las tareas siguientes
  vars:
    installer: /tmp/installer.php

  tasks:
    # vamos a instalar las herramientas que necesitamos en nuestra máquina y que podemos obtener
    # via apt install. En nuestro caso git y php.
    - name: Instalar herramientas
      apt:
        name:
          - php7.2-xml
          - php-mbstring
          - git
          - zip
        state: present
        # Necesario actualizar la cache porque no encontraba uno de los paquetes solicitados.
        update_cache: true

    # Descargamos el instalador de composer como lo haríamos si lo estuvieramos haciendo a mano:
    # curl -sSk https://getcomposer.org/installer -o /tmp/composer-installer.php
    - name: Descargar composer
      get_url:
        url: https://getcomposer.org/installer
        dest: "{{ installer }}"

    # instalamos composer con la herramienta de línea de órdenes de php que hemos instalado anteriormente.
    # Posteriormente movemos el ejecutable generado a una ruta accesible desde el PATH.
    # php /tmp/composer-installer.php
    # sudo mv composer.phar /usr/local/bin/composer
    - name: Instalar composer
    # Para ejecutar varias órdenes en un mismo 'task' se procede creando este "bucle" donde en la 
    # lista with_items se declaran las ordenes que la variable {{item}} irá tomando secuencialmente.
      command: "{{ item }}"
      with_items:
        - "php {{ installer }}"
        - mv composer.phar /usr/local/bin/composer
    # Borramos el instalador de composer pues ya no es necesario
    # sudo rm /tmp/composer-installer.php
    - name: Borrar instalador composer
      file:
        path: "{{ installer }}"
        state: absent
```

Básicamente lo que hacemos en primer lugar es instalar todos los paquetes que podemos y necesitamos a través de apt y, posteriormente en varios pasos instalamos el gestor de dependencias y build tool composer.

Este fichero será ejecutado cuando se llame a la orden `composer provision` que hemos definido para que llame a vagrant provision y, como su nombre indica (x2), provisione la máquina.

> Aclaración: al principio se ha dicho que se ha usado un fichero para el inventario que tiene este contenido
>```yml
>all:
>  hosts:
>    default:
>      ansible_host: 192.168.111.222
>``` 
>Es conocido que Vagrant genera automáticamente un inventario si le indicamos que usamos ansible para el provisionamiento, pero para tener mayor control en la gestión de los inventarios y además demostrar que se han comprendido los conceptos relacionados se ha optado por usar un inventario externo.