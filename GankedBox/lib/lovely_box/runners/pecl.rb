class LovelyBox
  module Runners
    class Pecl
      #
      # @param [Array] packages
      #
      def self.run(packages)
        threads = []

        threads << Thread.new do
          system('no | ' + Shellwords.join(%w{pecl install} + packages))
        end

        threads.map &:join
      end
    end
  end
end