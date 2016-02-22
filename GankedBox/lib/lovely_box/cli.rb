class LovelyBox
  class CLI
    #
    # @param [Array] argv
    #
    def self.run(argv)
      LovelyBox.ensure_user_config

      # Provision if provisioned = false or the versions don't match
      local = Config.get :local
      dist = Config.get(:dist)

      if local['provisioned'] != true || local['version'] != dist['version']
        Provision.new(dist['version'], Config.get(:dist)['provision']).run
      end

      Boot.new(dist['boot']).run
    end
  end
end