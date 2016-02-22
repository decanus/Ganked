class LovelyBox
  module Runners
    class Rubygems
      #
      # @param [Array] packages
      #
      def self.run(packages)
        system(Shellwords.join(%w{gem install} + packages))
      end
    end
  end
end