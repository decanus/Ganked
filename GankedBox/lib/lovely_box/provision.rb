class LovelyBox
  class Provision
    #
    # @return [Array]
    #
    attr_reader :packages

    #
    # @return [Array]
    #
    attr_reader :rubygems

    #
    # @return [Array]
    #
    attr_reader :pecl_packages

    #
    # @return [Array<Hash>]
    #
    attr_accessor :downloads

    #
    # @return [Array<Hash>]
    #
    attr_accessor :file_actions

    #
    # @return [Array<Hash>]
    #
    attr_accessor :commands

    #
    # @param [String] version
    # @param [Array] config
    #
    def initialize(version, config = {})
      @packages      = config['packages']
      @rubygems      = config['rubygems']
      @pecl_packages = config['pecl']
      @downloads     = config['download']
      @file_actions  = config['files']
      @commands      = config['commands']
      @version       = version
    end

    def run
      dir = File.join('/var/tmp', 'lovelybox_' + SecureRandom.hex(12))

      Dir.mkdir(dir)

      Dir.chdir(dir) do
        Runners::Yum.run(packages) unless packages.nil? || packages.empty?
        Runners::Rubygems.run(rubygems) unless rubygems.nil? || rubygems.empty?
        Runners::Pecl.run(pecl_packages) unless pecl_packages.nil? || pecl_packages.empty?
        Runners::Downloads.run(downloads)
        Runners::FileActions.run(file_actions)
        Runners::Commands.run(commands)

        local_config = Config.get :local
        local_config['provisioned'] = true
        local_config['version'] = @version

        File.write(File.join(LovelyBox.root, 'lovelybox.yml'), YAML.dump(local_config))
      end

      FileUtils.rm_rf(dir)
    end
  end
end
