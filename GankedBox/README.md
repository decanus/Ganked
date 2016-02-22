# LovelyBox 🐧

## Installation

1. Install [Virtualbox](http://virtualbox.org)
2. Install [Vagrant](http://www.vagrantup.com/downloads)
2. Clone this repo in the same directory aside all the other Ganked repos.
3. Open a command line and change to the GankedBox directory
4. Run `vagrant up`
5. Wait, hope and pray it works. 😆 (Maybe get yourself a coffe)
7. Run `vagrant reload`
6. Update the hostsfile and add the entries see [Hostfile](#hostfile).
7. Open [dev.ganked.net](http://dev.ganked.net)

## Commands

|  | Command  |
|----------|---|---|
| Start VM | ```vagrant up``` |
| Suspend VM | ```vagrant suspend```  |
| Stop VM | ```vagrant halt```  |
| Reboot VM | ```vagrant reload``` |
| SSH | ```vagrant ssh``` |

## Hard Reset
To completely erase the box and reinstall follow these steps:

1. Set **provisioned** to **false** in **lovelybox.yml**.
2. Run `vagrant destroy -f`
3. Follow from step no. 4 from "Installation"


## Hostfile
```
178.62.33.45 jenkins.ganked.net
192.168.6.6 dev.ganked.net
192.168.6.6 cdn.ganked.net
192.168.6.6 post.ganked.net
192.168.6.6 showcase.ganked.net
192.168.6.6 styleguide.ganked.net
192.168.6.6 dev.api.ganked.net
192.168.6.6 dev.fetch.ganked.net
192.168.6.6 offline.ganked.net
192.168.6.6 socket.ganked.net
```

## Custom Configuration
This is an example configuration found in **lovelybox.yml**.    
All keys need to be present except **network.public_ip**.

```yaml
---
network:
  private_ip: 192.168.6.6
  public_ip: 192.168.1.66
provisioned: false
hostname: lovelybox
```

## HTTPS
If you want to get rid of the HTTPS warnings in the dev environment mark these certs as trusted.

- [dev.api.ganked.net](conf/nginx/certs/dev.api.ganked.net/cert.pem)
- [dev.fetch.ganked.net](conf/nginx/certs/dev.fetch.ganked.net/cert.pem)
- [*.ganked.net](conf/nginx/certs/ganked.net/cert.pem)

### Steps on Mac
1. Open "Keychain Access"
2. (Optional) Create a new keychain *File > New Keychain*
3. Open **GankedBox/conf/nginx/certs/HOST-NAME** in Finder
4. Drag the cert.pem files into Keychain Access

Once added mark each cert as trusted:

1. Rightclick the certificate in Keychain Access
2. Click on "Get Info"
3. Click On "Trust"
4. Select "Always Trust" in the first dropdown
