class LovelyBox
  module Runners
    class FileActions
      #
      # @param [Array] actions
      #
      def self.run(actions)
        actions.each do |f|
          run_action(f)
        end
      end

      #
      # @param [String] source
      # @param [String] target
      # @param [Integer] mode
      #
      def self.run_action(file)
        case file['action']
        when 'delete'
          File.delete(file['target'])
        when 'create'
          File.write(file['target'], file['content'])

          if file['mode']
            File.chmod(file['mode'], file['target'])
          end
        when 'link'
          FileUtils.symlink(file['source'], file['target'])
        when 'copy'
          FileUtils.cp_r(file['source'], file['target'])
        when 'unpack'
          system('tar -xvf ' + file['source'])
        else
          puts "Unknown action #{file['action']}"
        end
      rescue
        nil
      end
    end
  end
end