class LovelyBox
  module Runners
    class Commands
      #
      # @param [Array] commands
      #
      def self.run(commands)
        commands.each do |command|
          puts "\n\e[0;34m==> Running #{command['command']} ...\e[0m\n"

          if command['dir']
            Dir.chdir(command['dir']) do
              system(command['command'])
            end
          else
            system(command['command'])
          end

          puts ''
        end
      end
    end
  end
end