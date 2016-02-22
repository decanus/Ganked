class LovelyBox
  class Boot
    #
    # @return [Array]
    #
    attr_reader :services

    #
    # @return [Array<Hash>]
    #
    attr_accessor :commands

    #
    # @param [Array] packages
    # @param [Array] rubygems
    # @param [Array] pecl_packages
    # @param [Array] downloads
    # @param [Array] file_actions
    # @param [Array] commands
    #
    def initialize(config = [])
      @services = config['services']
      @commands = config['commands']
    end

    def run
      Runners::Services.run(services)
      Runners::Commands.run(commands)
    end
  end
end