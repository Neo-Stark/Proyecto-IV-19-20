# Despliegue final

## Creación de la VM con Vagrant

Para crear la VM se ha usado **Vagrant**. Se ha usado Vagrant porque a partir de un fichero nos permite configurar todo lo que necesitamos para preparar nuestra máquina, desde la imagen base que queremos usar hasta el _provisioner_.

El fichero en cuestión, llamado **Vagrantfile**, es el siguiente:

```ruby
# El "2" en Vagrant.configure establece la versión de configuración (hasta el momento "1" y "2")
Vagrant.configure("2") do |config|

  # Establecemos la imágen base o `box` para nuestra maquina virtual, se trata de una
  # dummy-box específica para azure donde posteriormente instalaremos en azure el SO
  # que necesitemos
  config.vm.box = "azure"

  # Establecemos la localización de nuestra clave privada para poder acceder posteriormente las
  # máquinas desplegadas
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
```

Se ha usado ubuntu como imágen base porque es la que se viene usando a lo largo de todo el proyecto y es la que seguro se con certeza que posee todos los paquetes que necesito para hacer funcionar la aplicación. Por otra parte, se ha optado por la versión _18.04 LTS_ por ser una versión estable del sistema y además, ser la última.

Como vemos en el fichero Vagrantfile estamos levantando y provisionando dos máquinas al mismo tiempo en azure, una para la aplicación web y otra para la base de datos. Al compartir un grupo de recursos en azure ambas máquinas están conectadas a través de una red interna y cada una es provisionada con un playbook específico.

Para obtener los datos para poder desplegar máquinas en azure desde vagrant, usamos la herramienta az de azure y los siguientes comandos:

- `az account list --query "[?isDefault].id" -o tsv` para obtener Azure Subscription Id
- `az ad sp create-for-rbac` da la siguiente salida:

```json
{
  "appId": "XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX",
  "displayName": "some-display-name",
  "name": "http://azure-cli-*****",
  "password": "XXXXXXXXXXXXXXXXXXXX",
  "tenant": "XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX"
}
```

Donde tenant, appId y password corresponden a azure.tenant_id, azure.client_id y azure.client_secret en nuestro fichero vagrant.

## Aprovisionando la máquina usando ansible

Para aprovisionar la VM se ha optado por usar **ansible** por ser una de las herramientas más extendidas en los últimos años. Se ha utilizado la tecnologia de roles de ansible y se ha creado un rol específico para cada máquina y otro común para ambas donde se han definido las tareas. Los scripts son los siguientes:

- common/tasks:

```yml
---
# vamos a instalar las herramientas comunes
- name: Instalar herramientas
  apt:
    # Necesario actualizar la cache porque no encontraba uno de los paquetes solicitados.
    update_cache: true
    name:
      - git
      - zip
    state: present
```

- db/tasks:

```yml
---
# vamos a instalar las herramientas que necesitamos en nuestra máquina y que podemos obtener
# via apt install. En nuestro caso git y php.
- name: Instalar mysql server
  apt:
    name:
      - mysql-server
    state: present
```

- web/tasks:

```yml
---
# vamos a instalar las herramientas que necesitamos en nuestra máquina y que podemos obtener
# via apt install. En nuestro caso php.
- name: Instalar php y extensiones
  apt:
    name:
      - php7.2-cli
      - php7.2-xml
      - php-mbstring
    state: present

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

- web/vars:

```yml
---
# declaramos la variable installer por comodidad para usarla en las tareas siguientes
installer: /tmp/installer.php
```

- db.yml

```yml
---
- hosts: all
  become: yes
  roles:
    - common
    - db
```

- printcloud.yml

```yml
---
- hosts: all
  become: yes
  roles:
    - common
    - web
```

## Despliegue usando Ansible

Para desplegar nuestra máquina hemos definido el siguiente Playbook de Ansible en el directorio /despliegue:

```yml
---
- hosts: web
  become: yes
  tasks:
    # Con el módulo de git descargamos los fuentes que tenemos alojados en github al directorio
    # /web de la máquina virtual
    - name: descargar fuentes
      git:
        repo: https://github.com/Neo-Stark/Proyecto-IV-19-20.git
        dest: /web
    # Instalamos los paquetes y dependencias con composer que lo instalamos en el paso de
    # provisionamiento
    - name: instalar dependencias
      composer:
        command: install
        working_dir: /web
```

# Comando para crear, provisionar y desplegar nuestra aplicación

En la build tool se ha definido el siguiente script para que con una sola orden se levante la máquina virtual, se provisione y por último se despliegue.

```json
"despliegue-final": [
            "@composer vm-up",
            "@composer provision",
            "@composer deploy",
            "@composer start-service"
        ]
```

Este script llama a su vez a los diferentes scripts que se han ido definiendo a lo largo de los hitos:

```json
"vm-up": "vagrant up",
"provision": "vagrant provision",
"deploy": "ansible-playbook ./despliegue/despliegue.yml -i ./.vagrant/provisioners/ansible/inventory/vagrant_ansible_inventory",
"start-service": "vagrant ssh -c 'php -S 0.0.0.0:8080 -t /web/public' web"
```
